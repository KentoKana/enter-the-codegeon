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

let stageWin = (stageId, stars, moves) => {
	const xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function(){
		if (xhr.readyState === 4) {
			if (xhr.status === 200) {
				console.log(xhr.responseText);
			}
			else {
				alert("Connection was unsuccessful");
			}
		}
	}

	xhr.open('POST', 'controllers/stage-win.php');
	xhr.setRequestHeader('Content-Type', 'application/json');
	xhr.send(JSON.stringify({
		stageId: stageId,
		stars: stars,
		moves: moves
	}));
}

const pageInit = () => {
	const playingArea = document.querySelector("#playing-area");
	const mazeCanvas = new Maze();
	const moveButtons = document.querySelectorAll("button.movement-buttons");
	const moveList = document.querySelector("#move-list");
	const startButton = document.querySelector("#start-button");
	const undoButton = document.querySelector("#undo-button");
	const quitButton = document.querySelector("#quit-button");
	const stageInfo = document.querySelectorAll("input.stage-info");
	const resultModal = document.querySelector("#result-modal");

	let moves = [];
	let listOfMoves = [];
	let optimalSolution = stageInfo[4].value;

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
			moveList.innerHTML = "Move List: ";

			// Check if player won
			if(mazeCanvas.didWin()) {
				let stars;
				if(moves.length <= optimalSolution) {
					alert("Three stars");
					stars = 3;
				}
				else if(moves.length > optimalSolution && moves.length <= optimalSolution * 1.5) {
					alert("Two stars");
					stars = 2;
				}
				else {
					alert("One star");
					stars = 1;
				}
				stageWin(stageInfo[0].value, stars, moves.length);
			}
			else {
				alert("Scrubbed");
			}

			moves = [];
			listOfMoves = [];

			resultModal.style.display = "block";
		}
	});

	undoButton.addEventListener('mouseup', () => {
		moves.pop();
		listOfMoves.pop();
		moveList.innerHTML = "Move List: <br/>" + listOfMoves.join('<br/>');
	});
}

window.onload = pageInit;