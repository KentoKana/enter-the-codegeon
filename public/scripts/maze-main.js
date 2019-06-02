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
	const playingArea = document.querySelector("#playing-area");
	const mazeCanvas = new Maze();
	const moveButtons = document.querySelectorAll("button.movement-buttons");
	const moveList = document.querySelector("#move-list");
	const startButton = document.querySelector("#start-button");
	const undoButton = document.querySelector("#undo-button");
	const stageInfo = document.querySelectorAll("input.stage-info");

	let moves = [];
	let listOfMoves = [];

	mazeCanvas.initializeStage(stageInfo[1].value.split(','), stageInfo[2].value.split(','), 
		stageInfo[3].value.split(';'));

	playingArea.appendChild(mazeCanvas.canvas);

	window.onresize = () => {
		mazeCanvas.canvasRefresh();
	};

	for(let button of moveButtons) {
		button.addEventListener('mouseup', (e) => {
			moves.push(e.target.value);
			switch(e.target.value) {
				case "0":
					listOfMoves.push("Turn left");
					break;
				case "1":
					listOfMoves.push("Move Forward");
					break;
				case "2":
					listOfMoves.push("Turn Right");
					break;
			}
			moveList.innerHTML = "Move List: <br/>" + listOfMoves.join('<br/>');
		})
	}

	startButton.addEventListener('mouseup', async () => {
		disableButtons([...moveButtons, startButton, undoButton]);

		let isDone = await mazeCanvas.movePlayer(moves);

		if(isDone) {
			// enableButtons([...moveButtons, startButton, undoButton]);
			moveList.innerHTML = "Move List: ";
			moves = [];
			listOfMoves = [];
		}
	});

	undoButton.addEventListener('mouseup', () => {
		moves.pop();
		listOfMoves.pop();
		moveList.innerHTML = "Move List: <br/>" + listOfMoves.join('<br/>');
	});
}

window.onload = pageInit;