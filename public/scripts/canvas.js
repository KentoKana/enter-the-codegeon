"use strict";

function ChallengeCanvas() {
	this.canvas = document.createElement('canvas');
	this.canvas.id = 'challenge-canvas';

	this.context = this.canvas.getContext('2d');

	// grid will be widthInTiles x heightInTiles
	this.widthInTiles = 15;
	this.heightInTiles = 15;

    // method used to draw a 30x15 grid on the canvas of tile size this.canvas.width
	this.drawGrid = function() {
		this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);

		this.context.beginPath();
		this.context.strokeStyle = "black";

		let currentX = 0;
		let currentY = 0;

		while(currentX < this.canvas.width) {
			while(currentY < this.canvas.height) {
				this.context.rect(currentX, currentY, this.gridSize, this.gridSize);
				currentY += this.gridSize;
			}
			currentY = 0;
			currentX += this.gridSize;
		}

		this.context.stroke();
	};

	// method used to resize the canvas and redraw the grid accordingly
	this.canvasRefresh = function() {
		if(window.innerWidth < 1200) {
			this.canvas.width = window.innerWidth / 2;
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

		if(this.player){
			this.renderPlayer();
		}
	};

	// Creates a new player at xLocation, yLocation
	this.initializePlayer = function(xLocation=0, yLocation=0) {
		this.player = new Player(this.widthInTiles, this.heightInTiles, xLocation, yLocation);
	};

	// Render the player on the canvas
	this.renderPlayer = function() {
		this.context.drawImage(
			this.player.playerImage,
			this.player.animationFrames[this.player.currFrame],
			this.player.spriteSheetLocations[this.player.spriteSheetY],
			this.player.width,
			this.player.height,
			this.player.xPosition * this.gridSize,
			this.player.yPosition * this.gridSize,
			this.gridSize,
			this.gridSize
		);
	}

	// Move the player in the direction specified
	this.movePlayer = function(direction) {
		this.player.move(direction);
		this.canvasRefresh();
	}

	this.canvasRefresh();
}