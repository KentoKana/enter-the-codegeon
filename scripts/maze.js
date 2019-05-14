function Maze() {
	ChallengeCanvas.call(this);
	this.obstacleArray = new Array(this.heightInTiles);

	this.renderObstacles = function(obstacleArray) {
		for(let i=0; i<obstacleArray.length; i++) {
			let innerArray = obstacleArray[i];
			for(let j=0; j<innerArray.length; j++) {
				this.context.fillStyle = "orange";
				if(obstacleArray[i][j]) {
					this.context.fillRect(
						j * this.gridSize, 
						i * this.gridSize,
						this.gridSize,
						this.gridSize
					);
				}
			}
		}
	}

	// method used to resize the canvas and redraw the grid accordingly
	this.canvasRefresh = function() {
		if(window.innerWidth < 1200) {
			this.canvas.width = window.innerWidth - 50;
		}
		else {
			this.canvas.width = 1200;
		}

		this.gridSize = this.canvas.width / this.widthInTiles;
		if(this.player) {
			this.player.gridSize = this.gridSize;
		}

		this.canvas.height = this.gridSize * this.heightInTiles;

		this.drawGrid();

		this.renderObstacles(this.obstacleArray);

		this.context.fillStyle = "blue";
		this.context.fillRect(
			29 * this.gridSize, 
			9 * this.gridSize,
			this.gridSize,
			this.gridSize
		);

		if(this.player){
			this.renderPlayer();
		}
	}

	this.moveFrame = () => {
		if (this.player.currFrame === this.player.animationFrames.length - 1) {
			this.player.currFrame = 0;
		}
		else {
			this.player.currFrame++;
		}
	}

	this.player.move = async (direction) => {
		let moveDistance = 0;
		let moveFlag = false;
		let moveDelay = 250;

		switch(direction) {
			case "0":
				while(this.player.yPosition - moveDistance > 0 && 
						!this.obstacleArray[this.player.yPosition - moveDistance - 1][this.player.xPosition]) {
					moveDistance++;
				}
				for(let i=0; i<moveDistance; i++) {
					setTimeout(() => {
						this.player.spriteSheetY = 1;
						this.moveFrame();
						this.player.yPosition--;
						this.canvasRefresh();
					}, moveDelay * i)
				}
				break;
			case "1":
				while(this.player.xPosition + moveDistance < this.widthInTiles - 1 && 
						!this.obstacleArray[this.player.yPosition][this.player.xPosition + moveDistance + 1]) {
					moveDistance++;
				}
				for(let i=0; i<moveDistance; i++) {
					setTimeout(() => {
						this.player.spriteSheetY = 2;
						this.moveFrame();
						this.player.xPosition++;
						this.canvasRefresh();
					}, moveDelay * i)
				}
				break;
			case "2":
				while(this.player.yPosition + moveDistance < this.heightInTiles - 1 && 
						!this.obstacleArray[this.player.yPosition + moveDistance + 1][this.player.xPosition]) {
					moveDistance++;
				}
				for(let i=0; i<moveDistance; i++) {
					setTimeout(() => {
						this.player.spriteSheetY = 0;
						this.moveFrame();
						this.player.yPosition++;
						this.canvasRefresh();
					}, moveDelay * i)
				}
				break;
			case "3":
				while(this.player.xPosition - moveDistance > 0 && 
						!this.obstacleArray[this.player.yPosition][this.player.xPosition - moveDistance - 1]) {
					moveDistance++;
				}
				for(let i=0; i<moveDistance; i++) {
					setTimeout(() => {
						this.player.spriteSheetY = 3;
						this.moveFrame();
						this.player.xPosition--;
						this.canvasRefresh();
					}, moveDelay * i)
				}
				break;
		}

		return new Promise((resolve, reject) => {
			setTimeout(()=>{resolve(true)}, moveDelay * moveDistance);
		});
	}

	this.movePlayer = async (moveList) => {
		let moveArray = [];
		
		for(let move of moveList) {
			await this.player.move(move);
		}

		return true;
	}

	for(let i=0; i<this.obstacleArray.length; i++) {
		this.obstacleArray[i] = new Array(this.widthInTiles);
	}

	this.obstacleArray[11][1] = true;
	this.obstacleArray[7][10] = true;
	this.obstacleArray[12][9] = true;
	this.obstacleArray[8][2] = true;

	this.renderObstacles(this.obstacleArray);
	this.canvasRefresh();
}