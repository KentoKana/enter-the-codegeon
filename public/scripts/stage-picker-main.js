"use strict";

const pageInit = () => {
	const stageButtons = document.querySelectorAll("button.stage-button");
	let mazeCanvases = [];

	for(let button of stageButtons) {
		const xhr = new XMLHttpRequest();

		xhr.onreadystatechange = function(){
			if (xhr.readyState === 4) {
				if (xhr.status === 200) {
					const response = JSON.parse(xhr.responseText);
					const mazeCanvas = new Maze();

					mazeCanvas.initializeStage(
						response['startPosition'],
						response['goalPosition'],
						response['obstacles']
					);

					mazeCanvas.canvasRefresh(button.clientWidth * 0.90);

					button.appendChild(mazeCanvas.canvas);

					mazeCanvases.push(mazeCanvas);
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