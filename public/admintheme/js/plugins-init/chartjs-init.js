$(document).ready(function () {
	if($('#barChart_1').length > 0 ){
		let label = [];
		let pays = [];
		let result = $('.jsonchart').html();
		
		$.each(JSON.parse(result),function(index,value){
			label.push(value.date)
			pays.push(value.count)
			
		});
		const barChart_1 = document.getElementById("barChart_1").getContext('2d');
		let myPie = new Chart(barChart_1, {
			type: 'bar',
			data: {
				defaultFontFamily: 'Poppins',
				labels: label,
				datasets: [
					{
						label: "Продаж",
						data: pays,
						borderColor: 'rgba(91, 207, 197, 1)',
						borderWidth: "0",
						backgroundColor: 'rgba(91, 207, 197, 1)'
					}
				]
			},
			options: {
				legend: false, 
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true,
							stepSize: 1
						}
					}],
					xAxes: [{
						// Change here
						barPercentage: 0.5,
						
					}]
				}
			}
		});
	}
})