<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Bot\Bot;
use App\Models\Bot\BotTemplate;
use App\Models\Bot\BotMessage;
use App\Models\Bot\BotItemMessage;
use App\Models\Bot\BotButton;
use App\Models\Bot\SocialGroup;
use App\Models\Bot\GroupTemplate;
use App\Models\Bot\GroupMessage;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BotConstructController extends Controller
{
    public function index(){
        
        $botTemp = BotTemplate::all();
        $bots = Bot::all();
        return view('admin.botConstr.index',compact('botTemp','bots'));
    }

    public function templateCreate(Request $request){
        $bot = null;
        if($request->bot > 0){
            $bot = $request->bot;
        }
        $template = BotTemplate::create([
            'bot_id' => $bot,
            'name' => $request->name,
            'description' => $request->description,
        ]);

        $message1 = BotMessage::create([
            'bot_template_id' => $template->id,
            'name' => 'Первое сообщение',
            'trigger' => '/start',
        ]);
        $message1->id_message = $message1->id;
        $message1->save();

        $message2 = BotMessage::create([
            'bot_template_id' => $template->id,
            'name' => 'Меню',
            'trigger' => '/menu',
        ]);
        $message2->id_message = $message2->id;
        $message2->save();

        return redirect()->route('admin.botconstr.index');
    }

    public function editTemplate(Request $request, $template){
        $temp = BotTemplate::find($template);
        
        $groups = null;
        if($temp->bot_id > 0){
            $groups = SocialGroup::where('bot_id', $temp->bot_id)->get();
        }
        $bots = Bot::all();
        if ($request->isMethod('post')){
            
            $bot = null;
            if($request->bot > 0){
                $bot = $request->bot;
            }

            $active = 0;
            if($request->has('active')){
                $active = 1;
                $tempAll = BotTemplate::where([['bot_id',$bot],['active', 1]]);
                $tempAll->update(["active" => 0]);
            }
            
            $temp->bot_id = $bot;
            $temp->name = $request->name;
            $temp->description = $request->description;
            $temp->active = $active;
            $temp->privat = $request->privat;
            $temp->message = $request->message;
            $temp->ref_message = $request->ref_message;
            $temp->ref_dostigenie = $request->ref_dostigenie;
            $temp->images = $request->images;
            $temp->video_notice = $request->video_notice;
            $temp->video = $request->video;
            $temp->save();
            $degr = GroupTemplate::where('bot_template_id',$temp->id)->delete();
            if($request->group){
                
                foreach($request->group as $grid){
                    GroupTemplate::create([
                        'bot_template_id' => $temp->id,
                        'social_group_id' => $grid,
                    ]);
                }
            }

            return redirect()->route('admin.botconstr.index');
        }else{
            return view('admin.botConstr.editTemplate',compact('temp','bots','groups'));
        }
        
    }

    public function templateShow($template){
        $temp = BotTemplate::find($template);
        return view('admin.botConstr.messages',compact('temp'));
    }

    public function templateActivate($id){
        
        $temp = BotTemplate::find($id);

        $tempAll = BotTemplate::where([['bot_id',$temp->bot_id],['active', 1]]);
        $tempAll->update(["active" => 0]);

        $temp->active = 1;
        $temp->save();
        return redirect()->route('admin.botconstr.index');
    }

    public function deleteTemplate($id){
        $temp = BotTemplate::find($id);
        $temp->delete();
        return redirect()->route('admin.botconstr.index');
    }

    
    public function messageEdit(Request $request, $id){
        $message = BotMessage::find($id);
        $messageAll = BotMessage::where('bot_template_id', $message->bot_template_id)->get();
        $groups = null;
        if($message->template->bot_id > 0){
            $groups = SocialGroup::where('bot_id', $message->template->bot_id)->get();
        }
        $bots = Bot::all();
        return view('admin.botConstr.message',compact('message','messageAll','groups','bots'));
    }
    public function messageEditSave(Request $request, $id){
        $message = BotMessage::find($id);
        $message->privat = $request->privat;
        $message->message = $request->message;
        $message->save();
        $degr = GroupMessage::where('bot_message_id',$message->id)->delete();
        if($request->group){
            
            foreach($request->group as $grid){
                GroupMessage::create([
                    'social_group_id' => $grid,
                    'bot_message_id' => $message->id,
                ]);
            }
        }
        return redirect()->back();
    }

    public function messageCreate(Request $request, $temp){
        if($request->kandidat == 1){
            $message = BotMessage::create([
                'bot_template_id' => $temp,
                'name' => 'Список рефералов',
                'trigger' => '/kandidat',
            ]);
            $message->id_message = $message->id;
            $message->save();

            $message = BotItemMessage::create([
                'bot_message_id' => $message->id,
                'function' => 'referals',
            ]);

        }else{
            $message = BotMessage::create([
                'bot_template_id' => $temp,
                'name' => $request->name,
                'trigger' => '/'.$request->trigger,
            ]);
            $message->id_message = $message->id;
            $message->save();
        }
        
        return redirect()->route('admin.botconstr.templateShow', $temp);
    }
    
    public function messageItemCreate(Request $request){
        $fixed = 0;
        if($request->fixed){
            $fixed = 1;
        }
        $privat = 0;
        if($request->privat == 1){
            $privat = 1;
        }
        $message = BotItemMessage::create([
            'bot_message_id' => $request->messageid,
            'message' => $request->text,
            'images' => $request->photomessage,
            'video' => $request->videomessage,
            'function' => $request->function,
            'video_notice' => $request->videomessagenotice,
            'privat' => $privat,
        ]);
        return redirect()->back();
    }
    public function messageItemEdit(Request $request, $id){

        $message = BotItemMessage::find($id);
        return view('admin.botConstr.editItem',compact('message'));
    }
    public function messageItemEditSave(Request $request, $id){

        $privat = 0;
        if($request->privat == 1){
            $privat = 1;
        }

        $message = BotItemMessage::find($id);
        $message->bot_message_id = $request->messageid;
        $message->message = $request->text;
        $message->images = $request->photomessage;
        $message->video = $request->videomessage;
        $message->function = $request->function;
        $message->video_notice = $request->videomessagenotice;
        $message->privat = $privat;
        $message->save();
        return redirect()->back();
    }
    public function deleteFileTemp(Request $request)
    {
        $message = BotTemplate::find($request->templateId);
        $request->validate([
           'file_url' => 'required|string'
        ]);

        $fileUrl = $request->input('file_url');

        // Извлечение пути к файлу относительно storage/app/public
        $pathInStorage = parse_url($fileUrl, PHP_URL_PATH);
        $pathInStorage =  str_replace('/storage/', '', $pathInStorage);

        // Проверяем, что путь начинается с нужной директории (для безопасности)
        if (strpos($pathInStorage, 'videosTelegram/') === 0 ||  strpos($pathInStorage, 'images/') === 0) {
           // Проверка существования файла
            if(Storage::disk('public')->exists($pathInStorage)){
                // Удаление файла
                if(Storage::disk('public')->delete($pathInStorage)){
                    if($request->tip == 'video'){
                        $message->video = null;
                        $message->save();
                    }
                    if($request->tip == 'images'){
                        $message->images = null;
                        $message->save();
                    }
                    if($request->tip == 'video_notice'){
                        $message->video_notice = null;
                        $message->save();
                    }
                    
                    return response()->json(['message' => 'File deleted successfully'], 200);
                }else {
                    return response()->json(['message' => 'Failed to delete the file'], 500);
                }
            }else{
                return response()->json(['message' => 'File not found'], 404);
            }


        } else {
           return response()->json(['message' => 'Invalid file path'], 400);
        }

    }
    public function deleteFile(Request $request)
    {
        $message = BotItemMessage::find($request->messageId);
        $request->validate([
           'file_url' => 'required|string'
        ]);

        $fileUrl = $request->input('file_url');

        // Извлечение пути к файлу относительно storage/app/public
        $pathInStorage = parse_url($fileUrl, PHP_URL_PATH);
        $pathInStorage =  str_replace('/storage/', '', $pathInStorage);

        // Проверяем, что путь начинается с нужной директории (для безопасности)
        if (strpos($pathInStorage, 'videosTelegram/') === 0 ||  strpos($pathInStorage, 'images/') === 0) {
           // Проверка существования файла
            if(Storage::disk('public')->exists($pathInStorage)){
                // Удаление файла
                if(Storage::disk('public')->delete($pathInStorage)){
                    if($request->tip == 'video'){
                        $message->video = null;
                        $message->save();
                    }
                    if($request->tip == 'images'){
                        $message->images = null;
                        $message->save();
                    }
                    if($request->tip == 'video_notice'){
                        $message->video_notice = null;
                        $message->save();
                    }
                    
                    return response()->json(['message' => 'File deleted successfully'], 200);
                }else {
                    return response()->json(['message' => 'Failed to delete the file'], 500);
                }
            }else{
                return response()->json(['message' => 'File not found'], 404);
            }


        } else {
           return response()->json(['message' => 'Invalid file path'], 400);
        }

    }
    public function messageButtonCreate(Request $request){

        $callback = $request->callbackMessage;
        $type = 1;
        if($request->callbackMessage == 0){
            $callback = $request->callback;
            $type = 2;
        }
        if($request->callbackBot != 0){
            $callback = $request->callbackBot;
            $type = 3;
        }
        if($request->editiid != 0){
            $button = BotButton::find($request->editiid);
            $button->bot_item_message_id = $request->itemid;
            $button->text = $request->textbutton;
            $button->type_button = $type;
            $button->callback_button = $callback;
            $button->save();
        }else{
            $message = BotButton::create([
                'bot_item_message_id' => $request->itemid,
                'text' => $request->textbutton,
                'type_button' => $type,
                'callback_button' => $callback,
            ]);
        }
        
        return redirect()->back();
    }

    public function uploadPhoto(Request $request){
        $img1 = '';
        if($request->file('file')->getSize() > 10485760){
            return response()->json(['status' => 'err','location' => 'Размер файла не должне превышать 10 Мегабайт']);
        }
        $validator = $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png,gif,svg',
        ]);


        $file = $request->file('file');
        $upload_imagename = time().'.'.$file->getClientOriginalExtension();
        $storagePath = 'images/' . $upload_imagename;
        $upload_url = storage_path('app/public/' . $storagePath);

        $filename = $this->compress_image($_FILES["file"]["tmp_name"], $upload_url, 40);

        $img1 = request()->getSchemeAndHttpHost().Storage::url($storagePath);

        return response()->json(['status' => 'ok','location' => $img1]);
    }
    
    function compress_image($source_url, $destination_url, $quality) {
        $info = getimagesize($source_url);
            if ($info['mime'] == 'image/jpeg')
                    $image = imagecreatefromjpeg($source_url);
            elseif ($info['mime'] == 'image/gif')
                    $image = imagecreatefromgif($source_url);
            elseif ($info['mime'] == 'image/png')
                    $image = imagecreatefrompng($source_url);
            
                    $dir = dirname($destination_url);
            if(!is_dir($dir)){
                mkdir($dir, 0777, true);
            }
            imagejpeg($image, $destination_url, $quality);
            
        return $destination_url;
    }
    public function uploadVideo(Request $request){
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if (!$receiver->isUploaded()) {
            // file not uploaded
        }

        $fileReceived = $receiver->receive(); // receive file
        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            $file = $fileReceived->getFile(); // get file
            $extension = $file->getClientOriginalExtension();
            
            $filename = 'video-'.Str::random(10).'.'.$file->extension();

            $category = Storage::directories('public/videosTelegram');
            if(!$category){
                Storage::makeDirectory('public/videosTelegram');
            }
            
            Storage::putFileAs('public/videosTelegram', $file, $filename);

            // delete chunked file
            unlink($file->getPathname());
            return [
                'path' => $request->server()['HTTP_ORIGIN'].'/storage/videosTelegram/'.$filename,
                'filename' => $filename
            ];
        }

        // otherwise return percentage informatoin
        $handler = $fileReceived->handler();
        return [
            'done' => $handler->getPercentageDone(),
            'status' => true
        ];
    }
    public function uploadnoticevideo(Request $request){
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if (!$receiver->isUploaded()) {
            // file not uploaded
        }

        $fileReceived = $receiver->receive(); // receive file
        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            $file = $fileReceived->getFile(); // get file
            $extension = $file->getClientOriginalExtension();
            
            $filename = 'videoNotice-'.Str::random(10).'.'.$file->extension();

            $category = Storage::directories('public/videosTelegram');
            if(!$category){
                Storage::makeDirectory('public/videosTelegram');
            }
            
            Storage::putFileAs('public/videosTelegram', $file, $filename);

            // delete chunked file
            unlink($file->getPathname());
            return [
                'path' => $request->server()['HTTP_ORIGIN'].'/storage/videosTelegram/'.$filename,
                'filename' => $filename
            ];
        }

        // otherwise return percentage informatoin
        $handler = $fileReceived->handler();
        return [
            'done' => $handler->getPercentageDone(),
            'status' => true
        ];
    }
    public function messageDelete(Request $request, $id){
        $item = BotMessage::find($id);
        if($item->trigger == '/start'){
            return redirect()->back()->with('danger', 'Нельзя удалить этот пункт');
        }
        if($item->trigger == '/menu'){
            return redirect()->back()->with('danger', 'Нельзя удалить этот пункт');
        }
        $item->delete();
        return redirect()->back();
    }

    public function messageItemDelete(Request $request, $id){
        $item = BotItemMessage::find($id);
        $item->delete();
        return redirect()->back();
    }

    public function messageButtonDelete(Request $request, $id){
        $item = BotButton::find($id);
        $item->delete();
        return redirect()->back();
    }
}
