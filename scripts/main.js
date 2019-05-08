"use strict";

const pageInit = () => {
	const playingArea = document.querySelector("#playing-area");
	const challengeCanvas = new ChallengeCanvas();
	const moveButtons = document.querySelectorAll("button.movement-buttons");

	playingArea.appendChild(challengeCanvas.canvas);

	window.onresize = () => {
		challengeCanvas.canvasRefresh();
	};

	for(let button of moveButtons) {
		button.addEventListener('mouseup', function(e) {
			challengeCanvas.movePlayer(e.target.value);
		})
	}
}

window.onload = pageInit;