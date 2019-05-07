"use strict";

const pageInit = () => {
	const challengeCanvas = new ChallengeCanvas();
	challengeCanvas.drawGrid();

	document.body.appendChild(challengeCanvas.getCanvas());

	window.onresize = () => {
		challengeCanvas.canvasResize();
	};
}

window.onload = pageInit;