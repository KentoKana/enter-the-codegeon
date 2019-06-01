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
	const messages = document.querySelector("#message-area");
	const playingArea = document.querySelector("#playing-area");
	const mazeCanvas = new MazeBuilder();

	playingArea.appendChild(mazeCanvas.canvas);

	messages.innerHTML = "Start building your stage!";

	mazeCanvas.canvas.addEventListener('mousemove', (e) => {
		let boundingRect = mazeCanvas.canvas.getBoundingClientRect();
		let currXSquare = e.clientX - boundingRect.left;
		let currYSquare = e.clientY - boundingRect.top;
		
		mazeCanvas.updateGrid(currXSquare, currYSquare);
	});

	mazeCanvas.canvas.addEventListener('mouseup', (e) => {
		let boundingRect = mazeCanvas.canvas.getBoundingClientRect();
		let currXSquare = e.clientX - boundingRect.left;
		let currYSquare = e.clientY - boundingRect.top;
		
		let selectedOpt = document.querySelector('input[name=builder_options]:checked');

		if(!selectedOpt) {
			messages.innerHTML = "Please select something to place first.";
			messages.style.color = "red";
		}
		else {
			mazeCanvas.addObject(selectedOpt.value, currXSquare, currYSquare, messages);
		}
	});

	window.onresize = () => {
		mazeCanvas.canvasRefresh();
	};
}

window.onload = pageInit;