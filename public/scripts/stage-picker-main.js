"use strict";

let disableButtons = (buttons) => {
	for(let button of buttons) {
		button.disabled = true;
	}
}

let enableButtons = (buttons) => {
	for(let button of buttons) {
		button.disabled = false;
	}
}

const pageInit = () => {
	const stageButtons = document.querySelectorAll("button.stage-button");

	disableButtons(stageButtons);
	let mazeCanvases = [];

	for(let button of stageButtons) {
		const xhr = new XMLHttpRequest();

		xhr.onreadystatechange = function(){
			if (xhr.readyState === 4) {
				if (xhr.status === 200) {
					const response = JSON.parse(xhr.responseText);
					const mazeCanvas = new Maze();
					const stageScore = document.createElement("div");

					mazeCanvas.initializeStage(
						response['startPosition'],
						response['goalPosition'],
						response['obstacles']
					);

					mazeCanvas.canvasBackground.onload = () => {
						mazeCanvas.canvasRefresh(button.clientWidth * 0.90);
					};
					
					mazeCanvas.crateImage.onload = () => {
						mazeCanvas.canvasRefresh(button.clientWidth * 0.90);
					};

					mazeCanvas.treasureImage.onload = () => {
						mazeCanvas.canvasRefresh(button.clientWidth * 0.90);
					};

					mazeCanvas.canvasRefresh(button.clientWidth * 0.90);

					button.appendChild(mazeCanvas.canvas);

					mazeCanvases.push(mazeCanvas);

					for(let i=1; i<=3; i++) {
						stageScore.innerHTML += (i <= response['stars']) ?
							'<span class="fa fa-star checked"></span>' :
							'<span class="fa fa-star"></span>';
					}

					button.appendChild(stageScore);

					if(mazeCanvases.length === stageButtons.length) {
						enableButtons(stageButtons);
					}
				}
				else {
					alert("Connection was unsuccessful");
				}
			}
		}

		xhr.open('POST', 'controllers/get-stage-info.php');
		xhr.setRequestHeader('Content-Type', 'application/json');
		xhr.send(JSON.stringify({ stageId: button.value }));
	}

	window.onresize = () => {
		for(let mazeCanvas of mazeCanvases) {
			mazeCanvas.canvasRefresh(stageButtons[0].clientWidth * 0.90);
		}
	};
}

window.onload = pageInit;