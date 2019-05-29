function Maze() {
	ChallengeCanvas.call(this);
	this.boardArray = new Array(this.heightInTiles);
	this.moveDelay = 250;
	this.winningSquare = {
		row: 9,
		column: 13
	};

	this.renderObstacles = function(boardArray) {
		for(let i=0; i<boardArray.length; i++) {
			let innerArray = boardArray[i];
			for(let j=0; j<innerArray.length; j++) {
				this.context.fillStyle = "orange";
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
		if(window.innerWidth < 1200) {
			this.canvas.width = window.innerWidth / 2
			;
		}
		else {
			this.canvas.width = 1200 / 2;
		}

		this.gridSize = this.canvas.width / this.widthInTiles;
		if(this.player) {
			this.player.gridSize = this.gridSize;
		}

		this.canvas.height = this.gridSize * this.heightInTiles;

		this.drawGrid();

		this.renderObstacles(this.boardArray);

		this.renderWinningSquare();

		if(this.player){
			this.renderPlayer();
		}
	};

	this.moveFrame = () => {
		if (this.player.currFrame === this.player.animationFrames.length - 1) {
			this.player.currFrame = 0;
		}
		else {
			this.player.currFrame++;
		}
	};

	// 0 = up, 1=right, 2=down, 3=left
	// Move forward until an obstacle or a wall is hit
	this.player.move = async () => {
		let moveDistance = 0;

		switch(this.player.spriteSheetY) {
			case 0:
				while(this.player.yPosition - moveDistance > 0 && 
						this.boardArray[this.player.yPosition - moveDistance - 1][this.player.xPosition] !== "obs" &&
						this.boardArray[this.player.yPosition - moveDistance][this.player.xPosition] !== "win") {
					moveDistance++;
				}
				for(let i=0; i<moveDistance; i++) {
					setTimeout(() => {
						this.moveFrame();
						this.player.yPosition--;
						this.canvasRefresh();
					}, this.moveDelay * i)
				}
				break;
			case 1:
				while(this.player.xPosition + moveDistance < this.widthInTiles - 1 && 
						this.boardArray[this.player.yPosition][this.player.xPosition + moveDistance + 1] !== "obs" &&
						this.boardArray[this.player.yPosition][this.player.xPosition + moveDistance] !== "win") {
					moveDistance++;
				}
				for(let i=0; i<moveDistance; i++) {
					setTimeout(() => {
						this.moveFrame();
						this.player.xPosition++;
						this.canvasRefresh();
					}, this.moveDelay * i)
				}
				break;
			case 2:
				while(this.player.yPosition + moveDistance < this.heightInTiles - 1 && 
						this.boardArray[this.player.yPosition + moveDistance + 1][this.player.xPosition] !== "obs" &&
						this.boardArray[this.player.yPosition + moveDistance][this.player.xPosition] !== "win") {
					moveDistance++;
				}
				for(let i=0; i<moveDistance; i++) {
					setTimeout(() => {
						this.moveFrame();
						this.player.yPosition++;
						this.canvasRefresh();
					}, this.moveDelay * i)
				}
				break;
			case 3:
				while(this.player.xPosition - moveDistance > 0 && 
						this.boardArray[this.player.yPosition][this.player.xPosition - moveDistance - 1] !== "obs" &&
						this.boardArray[this.player.yPosition][this.player.xPosition - moveDistance] !== "win") {
					moveDistance++;
				}
				for(let i=0; i<moveDistance; i++) {
					setTimeout(() => {
						this.moveFrame();
						this.player.xPosition--;
						this.canvasRefresh();
					}, this.moveDelay * i)
				}
				break;
		}

		return new Promise((resolve, reject) => {
			setTimeout(()=>{resolve(true)}, this.moveDelay * moveDistance);
		});
	};

	// Rotate player left (1) or right (0)
	this.rotatePlayer = async (direction) => {
		// turn clockwise
		if(direction === 0) {
			this.player.spriteSheetY = (this.player.spriteSheetY + 1) % 4;
		}
		// turn counterclockwise
		if(direction === 1) {
			this.player.spriteSheetY--;
			if(this.player.spriteSheetY === -1) {
				this.player.spriteSheetY = 3;
			}
		}
		
		this.canvasRefresh();

		return new Promise((resolve, reject) => {
			setTimeout(()=>{resolve(true)}, this.moveDelay);
		});
	};

	// Move player by executing a list of moves in a sequence
	this.movePlayer = async (moveList) => {
		let moveArray = [];
		
		for(let move of moveList) {
			switch (move) {
				case "0":
					await this.rotatePlayer(1);
					break;
				case "1":
					await this.player.move();
					break;
				case "2":
					await this.rotatePlayer(0);
					break;
			}
		}

		return true;
	};

	this.checkWinnable = (boardArray, moveList) => {
		let result;
		let newMoveList;
		let solution = [];

		if(boardArray[this.player.yPosition][this.player.xPosition] === "win") {
			return moveList;
		}

		for(let i=0; i<4; i++) {
			let moveDistance = 0;
			switch(i) {
				case 0:
					newMoveList = [...moveList, 1];
					break;
				case 1:
					newMoveList = [...moveList, 2, 1];
					this.player.spriteSheetY = (this.player.spriteSheetY + i) % 4;
					break;
				case 2:
					newMoveList = [...moveList, 2, 2, 1];
					this.player.spriteSheetY = (this.player.spriteSheetY + i) % 4;
					break;
				case 3:
					newMoveList = [...moveList, 0, 1];
					this.player.spriteSheetY = (this.player.spriteSheetY + i) % 4;
					break;
			}

			switch(this.player.spriteSheetY) {
				case 0:
					while(this.player.yPosition - moveDistance > 0 && 
							boardArray[this.player.yPosition - moveDistance - 1][this.player.xPosition] !== "obs" &&
							boardArray[this.player.yPosition - moveDistance][this.player.xPosition] !== "win") {
						moveDistance++;
					}
					this.player.yPosition = this.player.yPosition - moveDistance;

					if(boardArray[this.player.yPosition][this.player.xPosition] !== true) {
						if(boardArray[this.player.yPosition][this.player.xPosition] !== "win") {
							boardArray[this.player.yPosition][this.player.xPosition] = true;
						}
						result = this.checkWinnable(boardArray, newMoveList);
						if(result) {
							// solutions = [...result, ...solutions];
							if(solution.length === 0 || result.length < solution.length) { solution = result };
						}
						if(boardArray[this.player.yPosition][this.player.xPosition] !== "win") {
							boardArray[this.player.yPosition][this.player.xPosition] = null;
						}
					}

					this.player.yPosition = this.player.yPosition + moveDistance;

					break;
				case 1:
					while(this.player.xPosition + moveDistance < this.widthInTiles - 1 && 
							boardArray[this.player.yPosition][this.player.xPosition + moveDistance + 1] !== "obs" &&
							boardArray[this.player.yPosition][this.player.xPosition + moveDistance] !== "win") {
						moveDistance++;
					}
					this.player.xPosition = this.player.xPosition + moveDistance;

					if(boardArray[this.player.yPosition][this.player.xPosition] !== true) {
						if(boardArray[this.player.yPosition][this.player.xPosition] !== "win") {
							boardArray[this.player.yPosition][this.player.xPosition] = true;
						}
						result = this.checkWinnable(boardArray, newMoveList);
						if(result) {
							// solutions = [...result, ...solutions];
							if(solution.length === 0 || result.length < solution.length) { solution = result };
						}
						if(boardArray[this.player.yPosition][this.player.xPosition] !== "win") {
							boardArray[this.player.yPosition][this.player.xPosition] = null;
						}
					}

					this.player.xPosition = this.player.xPosition - moveDistance;
					
					break;
				case 2:
					while(this.player.yPosition + moveDistance < this.heightInTiles - 1 && 
							boardArray[this.player.yPosition + moveDistance + 1][this.player.xPosition] !== "obs" &&
							boardArray[this.player.yPosition + moveDistance][this.player.xPosition] !== "win") {
						moveDistance++;
					}
					this.player.yPosition = this.player.yPosition + moveDistance;

					if(boardArray[this.player.yPosition][this.player.xPosition] !== true) {
						if(boardArray[this.player.yPosition][this.player.xPosition] !== "win") {
							boardArray[this.player.yPosition][this.player.xPosition] = true;
						}
						result = this.checkWinnable(boardArray, newMoveList);
						if(result) {
							// solutions = [...result, ...solutions];
							if(solution.length === 0 || result.length < solution.length) { solution = result };
						}
						if(boardArray[this.player.yPosition][this.player.xPosition] !== "win") {
							boardArray[this.player.yPosition][this.player.xPosition] = null;
						}
					}

					this.player.yPosition = this.player.yPosition - moveDistance;
					
					break;
				case 3:
					while(this.player.xPosition - moveDistance > 0 && 
							boardArray[this.player.yPosition][this.player.xPosition - moveDistance - 1] !== "obs" &&
							boardArray[this.player.yPosition][this.player.xPosition - moveDistance] !== "win") {
						moveDistance++;
					}
					this.player.xPosition = this.player.xPosition - moveDistance;

					if(boardArray[this.player.yPosition][this.player.xPosition] !== true) {
						if(boardArray[this.player.yPosition][this.player.xPosition] !== "win") {
							boardArray[this.player.yPosition][this.player.xPosition] = true;
						}
						result = this.checkWinnable(boardArray, newMoveList);
						if(result) {
							// solutions = [...result, ...solutions];
							if(solution.length === 0 || result.length < solution.length) { solution = result };
						}
						if(boardArray[this.player.yPosition][this.player.xPosition] !== "win") {
							boardArray[this.player.yPosition][this.player.xPosition] = null;
						}
					}

					this.player.xPosition = this.player.xPosition + moveDistance;
					
					break;
			}
			this.player.spriteSheetY = (this.player.spriteSheetY + (4-i)) % 4;
		}

		return solution.length === 0 ? false : solution;
	};

	for(let i=0; i<this.boardArray.length; i++) {
		this.boardArray[i] = new Array(this.widthInTiles);
	}

	this.boardArray[11][1] = "obs";
	this.boardArray[7][10] = "obs";
	this.boardArray[12][9] = "obs";
	this.boardArray[8][2] = "obs";
	this.boardArray[this.winningSquare.row][this.winningSquare.column] = "win";
	console.log(this.checkWinnable(this.boardArray, []));

	this.canvasRefresh();
}