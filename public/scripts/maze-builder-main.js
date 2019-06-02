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
	const messages = document.querySelector('#message-area');
	const playingArea = document.querySelector('#playing-area');
	const nameField = document.querySelector('#stage-name');
	const checkButton = document.querySelector('#check-solution');
	const submitButton = document.querySelector('#submit-stage');
	const mazeCanvas = new MazeBuilder();
	let solution = [];

	playingArea.appendChild(mazeCanvas.canvas);

	messages.innerHTML = 'Start building your stage!';

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
			messages.innerHTML = 'Please select something to place first.';
			messages.style.color = 'red';
		}
		else {
			mazeCanvas.addObject(selectedOpt.value, currXSquare, currYSquare, messages);
		}

		submitButton.disabled = true;
		checkButton.disabled = false;
	});

	checkButton.addEventListener('mouseup', () => {
		if(mazeCanvas.checkSubmittable()) {
			let winnable = mazeCanvas.checkWinnable(mazeCanvas.boardArray, []);
			if(winnable) {
				messages.innerHTML = 'Your stage is solvable. Solution is: ' + winnable.join(', ') +
						'. You can submit your stage now.';
				solution = winnable;
				messages.style.color = 'blue';
				submitButton.disabled = false;
				checkButton.disabled = true;
			}
			else {
				messages.innerHTML = 'Your stage is not solvable. Please rearrange your obstacles';
				messages.style.color = 'red';
			}
		}
		else {
			messages.innerHTML = 'Missing player or goal square.';
			messages.style.color = 'red';
		}
	});

	submitButton.addEventListener('mouseup', () => {
		let xhr = new XMLHttpRequest();

		if(nameField.value === '') {
			messages.innerHTML = 'Please enter a stage name!';
			messages.style.color = 'red';
		}
		else {
			xhr.onreadystatechange = function(){
				if (xhr.readyState === 4) {
					if (xhr.status === 200) {
						alert(xhr.responseText);
						window.location = "profile";
					}
					else {
						alert("Connection was unsuccessful");
					}
				}
			}

			xhr.open('POST', 'controllers/add-stage.php');
			xhr.setRequestHeader('Content-Type', 'application/json');
			xhr.send(JSON.stringify(
				{
					stageName: nameField.value,
					startPosition: [mazeCanvas.player.yPosition, mazeCanvas.player.xPosition],
					goalPosition: [mazeCanvas.winningSquare.row, mazeCanvas.winningSquare.column],
					obstacles: mazeCanvas.getObstacles(),
					solution: solution
				}
			));
		}
	});

	window.onresize = () => {
		mazeCanvas.canvasRefresh();
	};

	submitButton.disabled = true;
}

window.onload = pageInit;
