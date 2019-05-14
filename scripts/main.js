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

	let moves = [];

	playingArea.appendChild(mazeCanvas.canvas);

	window.onresize = () => {
		mazeCanvas.canvasRefresh();
	};

	for(let button of moveButtons) {
		button.addEventListener('mouseup', (e) => {
			moves.push(e.target.value);
			moveList.innerHTML = "Move List: " + moves.join(', ');
		})
	}

	startButton.addEventListener('mouseup', async () => {
		disableButtons([...moveButtons, startButton, undoButton]);

		let isDone = await mazeCanvas.movePlayer(moves);

		if(isDone) {
			enableButtons([...moveButtons, startButton, undoButton]);
			moveList.innerHTML = "Move List: ";
			moves = [];
		}
	});

	undoButton.addEventListener('mouseup', () => {
		moves.pop();
		moveList.innerHTML = "Move List: " + moves.join(', ');
	});
}

window.onload = pageInit;