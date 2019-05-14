"use strict";

function ChallengeCanvas() {
	this.canvas = document.createElement('canvas');
	this.canvas.id = 'challenge-canvas';

	this.context = this.canvas.getContext('2d');

	// grid will be widthInTiles x heightInTiles
	this.widthInTiles = 30;
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

		if(this.player){
			this.renderPlayer();
		}
	};

	this.initializePlayer = function() {
		this.player = new Player(this.widthInTiles, this.heightInTiles, 2, 3);
		this.renderPlayer();
	};

	this.renderPlayer = function() {
		this.context.fillStyle = "green";
		this.context.fillRect(
			this.player.xPosition * this.gridSize, 
			this.player.yPosition * this.gridSize,
			this.gridSize,
			this.gridSize
		);
	}

	this.movePlayer = function(direction) {
		this.player.move(direction);
		this.canvasRefresh();
	}

	this.canvasRefresh();
	this.initializePlayer();
}