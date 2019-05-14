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

	let moves = [];

	playingArea.appendChild(mazeCanvas.canvas);

	window.onresize = () => {
		mazeCanvas.canvasRefresh();
	};

	for(let button of moveButtons) {
		button.addEventListener('mouseup', function(e) {
			moves.push(e.target.value);
			moveList.innerHTML += `${e.target.value}, `;
		})
	}

	startButton.addEventListener('mouseup', async () => {
		disableButtons(moveButtons);

		let isDone = await mazeCanvas.movePlayer(moves);

		if(isDone) {
			enableButtons(moveButtons);
			moveList.innerHTML = "Move List: ";
			moves = [];
		}
	});
}

window.onload = pageInit;