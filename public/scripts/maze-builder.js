function MazeBuilder() {
	ChallengeCanvas.call(this);

	this.solutionBoard = null;

	this.hasPlayer = false;
	this.hasGoal = false;

	this.boardArray = new Array(this.heightInTiles);
	for(let i=0; i<this.boardArray.length; i++) {
		this.boardArray[i] = new Array(this.widthInTiles);
	}

	this.updateGrid = function(hoveredX, hoveredY) {
		let gridX = Math.floor(hoveredX / this.gridSize);
		let gridY = Math.floor(hoveredY / this.gridSize);

		this.canvasRefresh();
		this.context.fillStyle = "rgb(255,255,0,0.1)";
		this.context.fillRect(gridX * this.gridSize, gridY * this.gridSize, this.gridSize, this.gridSize);
	};

	this.renderObstacles = function(boardArray) {
		for(let i=0; i<boardArray.length; i++) {
			let innerArray = boardArray[i];
			for(let j=0; j<innerArray.length; j++) {
				this.context.fillStyle = "red";
				if(boardArray[i][j] === "obs") {
					this.context.fillRect(
						j * this.gridSize, 
						i * this.gridSize,
						this.gridSize,
						this.gridSize
					);
				}
			}
		}
	};

	this.renderWinningSquare = () => {
		this.context.fillStyle = "blue";
		this.context.fillRect(
			this.winningSquare.column * this.gridSize, 
			this.winningSquare.row * this.gridSize,
			this.gridSize,
			this.gridSize
		);
	};

	// method used to resize the canvas and redraw the grid accordingly
	this.canvasRefresh = function() {
		if (window.innerWidth < 1200) {
			this.canvas.width = window.innerHeight / 1.5 < window.innerWidth / 2 ? window.innerHeight / 1.5 : window.innerWidth / 2;
		}
		else {
			this.canvas.width = window.innerHeight / 1.5 < 600 ? window.innerHeight / 1.5 : 600;
		}

		this.gridSize = this.canvas.width / this.widthInTiles;
		if(this.player) {
			this.player.gridSize = this.gridSize;
		}

		this.canvas.height = this.gridSize * this.heightInTiles;

		this.drawGrid();

		this.renderObstacles(this.boardArray);

		if(this.winningSquare) this.renderWinningSquare();

		if(this.player) this.renderPlayer();
	};

	this.checkWinnable = () => {
		let result;
		let newMoveList;
		let solutions = [];

		if(this.boardArray[this.player.yPosition][this.player.xPosition] === "win") {
			return [];
		}
		else if(this.solutionBoard[this.player.yPosition][this.player.xPosition] === "no solution") {
			return false;
		}
		else if(Array.isArray(this.solutionBoard[this.player.yPosition][this.player.xPosition])) {
			return this.solutionBoard[this.player.yPosition][this.player.xPosition];
		}

		for(let i=0; i<4; i++) {
			let moveDistance = 0;
			switch(i) {
				case 0:
					newMoveList = ['Move Forward'];
					break;
				case 1:
					newMoveList = ['Turn Right', 'Move Forward'];
					this.player.spriteSheetY = (this.player.spriteSheetY + i) % 4;
					break;
				case 2:
					newMoveList = ['Turn Right', 'Turn Right', 'Move Forward'];
					this.player.spriteSheetY = (this.player.spriteSheetY + i) % 4;
					break;
				case 3:
					newMoveList = ['Turn Left', 'Move Forward'];
					this.player.spriteSheetY = (this.player.spriteSheetY + i) % 4;
					break;
			}

			switch(this.player.spriteSheetY) {
				case 0:
					while(this.player.yPosition - moveDistance > 0 && 
							this.boardArray[this.player.yPosition - moveDistance - 1][this.player.xPosition] !== "obs" &&
							this.boardArray[this.player.yPosition - moveDistance][this.player.xPosition] !== "win") {
						moveDistance++;
					}
					this.player.yPosition = this.player.yPosition - moveDistance;

					if(this.boardArray[this.player.yPosition][this.player.xPosition] !== true) {
						if(this.boardArray[this.player.yPosition][this.player.xPosition] !== "win") {
							this.boardArray[this.player.yPosition][this.player.xPosition] = true;
						}
						result = this.checkWinnable();
						if(result) {
							solutions.push([...newMoveList, ...result]);
						}
						if(this.boardArray[this.player.yPosition][this.player.xPosition] !== "win") {
							this.boardArray[this.player.yPosition][this.player.xPosition] = null;
						}
					}

					this.player.yPosition = this.player.yPosition + moveDistance;

					break;
				case 1:
					while(this.player.xPosition + moveDistance < this.widthInTiles - 1 && 
							this.boardArray[this.player.yPosition][this.player.xPosition + moveDistance + 1] !== "obs" &&
							this.boardArray[this.player.yPosition][this.player.xPosition + moveDistance] !== "win") {
						moveDistance++;
					}
					this.player.xPosition = this.player.xPosition + moveDistance;

					if(this.boardArray[this.player.yPosition][this.player.xPosition] !== true) {
						if(this.boardArray[this.player.yPosition][this.player.xPosition] !== "win") {
							this.boardArray[this.player.yPosition][this.player.xPosition] = true;
						}
						result = this.checkWinnable();
						if(result) {
							solutions.push([...newMoveList, ...result]);
						}
						if(this.boardArray[this.player.yPosition][this.player.xPosition] !== "win") {
							this.boardArray[this.player.yPosition][this.player.xPosition] = null;
						}
					}

					this.player.xPosition = this.player.xPosition - moveDistance;
					
					break;
				case 2:
					while(this.player.yPosition + moveDistance < this.heightInTiles - 1 && 
							this.boardArray[this.player.yPosition + moveDistance + 1][this.player.xPosition] !== "obs" &&
							this.boardArray[this.player.yPosition + moveDistance][this.player.xPosition] !== "win") {
						moveDistance++;
					}
					this.player.yPosition = this.player.yPosition + moveDistance;

					if(this.boardArray[this.player.yPosition][this.player.xPosition] !== true) {
						if(this.boardArray[this.player.yPosition][this.player.xPosition] !== "win") {
							this.boardArray[this.player.yPosition][this.player.xPosition] = true;
						}
						result = this.checkWinnable();
						if(result) {
							solutions.push([...newMoveList, ...result]);
						}
						if(this.boardArray[this.player.yPosition][this.player.xPosition] !== "win") {
							this.boardArray[this.player.yPosition][this.player.xPosition] = null;
						}
					}

					this.player.yPosition = this.player.yPosition - moveDistance;
					
					break;
				case 3:
					while(this.player.xPosition - moveDistance > 0 && 
							this.boardArray[this.player.yPosition][this.player.xPosition - moveDistance - 1] !== "obs" &&
							this.boardArray[this.player.yPosition][this.player.xPosition - moveDistance] !== "win") {
						moveDistance++;
					}
					this.player.xPosition = this.player.xPosition - moveDistance;

					if(this.boardArray[this.player.yPosition][this.player.xPosition] !== true) {
						if(this.boardArray[this.player.yPosition][this.player.xPosition] !== "win") {
							this.boardArray[this.player.yPosition][this.player.xPosition] = true;
						}
						result = this.checkWinnable();
						if(result) {
							solutions.push([...newMoveList, ...result]);
						}
						if(this.boardArray[this.player.yPosition][this.player.xPosition] !== "win") {
							this.boardArray[this.player.yPosition][this.player.xPosition] = null;
						}
					}

					this.player.xPosition = this.player.xPosition + moveDistance;
					
					break;
			}
			this.player.spriteSheetY = (this.player.spriteSheetY + (4-i)) % 4;
		}

		let smallestSolution = [];
		for(let solution of solutions) {
			if(solution.length < smallestSolution.length || smallestSolution.length === 0) {
				smallestSolution = solution;
			}
		}

		if(smallestSolution.length === 0) {
			this.solutionBoard[this.player.yPosition][this.player.xPosition] = "no solution";
			return false;
		}
		else {
			this.solutionBoard[this.player.yPosition][this.player.xPosition] = smallestSolution;
			return smallestSolution;
		}
	};

	this.findSolution = () => {
		let origBoard = this.boardArray.map((row) => {
			return [...row];
		});
		this.solutionBoard = origBoard.map((row) => {
			return [...row];
		});

		let result = this.checkWinnable();

		this.solutionBoard = null;
		this.boardArray = origBoard.map((row) => {
			return [...row];
		});

		return result;
	}

	this.getObstacles = () => {
		let obstacles = [];

		for(let i=0; i<this.boardArray.length; i++) {
			for(let j=0; j<this.boardArray[i].length; j++) {
				if(this.boardArray[i][j] === "obs") {
					obstacles.push([i,j]);
				}
			}
		}

		return obstacles;
	};

	this.checkSubmittable = () => {
		return this.hasPlayer && this.hasGoal;
	};

	this.addObject = (objectType, hoveredX, hoveredY, messages) => {
		let gridX = Math.floor(hoveredX / this.gridSize);
		let gridY = Math.floor(hoveredY / this.gridSize);

		// Removing objects from the board
		if(objectType === "3") {
			// Nothing to remove
			if(!this.boardArray[gridY][gridX]) {
				messages.innerHTML = "Nothing to remove here!";
				messages.style.color = "red";
			}
			// Removing the goal square
			else if(this.boardArray[gridY][gridX] === "win") {
				this.boardArray[gridY][gridX] = null;
				this.winningSquare = null;
				this.hasGoal = false;
				messages.innerHTML = "Goal square has been removed!";
				messages.style.color = "green";
				this.canvasRefresh();
			}
			// Removing the player square
			else if(this.boardArray[gridY][gridX] === "player") {
				this.boardArray[gridY][gridX] = null;
				this.player = null;
				this.hasPlayer = false;
				messages.innerHTML = "Player starting spot has been removed!";
				messages.style.color = "green";
				this.canvasRefresh();
			}
			// Removing Obstacles
			else {
				this.boardArray[gridY][gridX] = null;
				messages.innerHTML = "Obstacle has been removed!";
				messages.style.color = "green";
				this.canvasRefresh();
			}
		}
		// Trying to add to a spot that's already taken
		else if(this.boardArray[gridY][gridX]) {
			messages.innerHTML = "This spot is already taken";
			messages.style.color = "red";
		}
		// Adding to an empty slot
		else {
			switch(objectType) {
				// Adding the goal square
				case "0":
					if(this.winningSquare) this.boardArray[this.winningSquare.row][this.winningSquare.column] = null;
					this.winningSquare = {
						row: gridY,
						column: gridX
					};
					this.boardArray[gridY][gridX] = "win";
					messages.innerHTML = "Goal square has been added!";
					messages.style.color = "green";
					this.hasGoal = true;
					this.canvasRefresh();
					break;
				// Adding the player starting spot
				case "1":
					if(this.player) this.boardArray[this.player.yPosition][this.player.xPosition] = null;
					this.initializePlayer(gridX, gridY);
					this.boardArray[gridY][gridX] = "player";
					messages.innerHTML = "Player has been added!";
					messages.style.color = "green";
					this.canvasRefresh();
					this.hasPlayer = true;
					break;
				// Adding an obstacle
				case "2":
					this.boardArray[gridY][gridX] = "obs";
					messages.innerHTML = "Obstacle has been added!";
					messages.style.color = "green";
					this.canvasRefresh();
					break;
			}
		}
	};

	this.canvasRefresh();
}