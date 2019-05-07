function ChallengeCanvas() {
	this.canvas = document.createElement('canvas');
	this.canvas.id = 'challenge-canvas';
	this.canvas.width = window.innerWidth / 2;
	this.canvas.height = window.innerHeight / 2;

	this.context = this.canvas.getContext('2d');
	this.gridHeight = this.canvas.height / 15;
	this.gridWidth = this.canvas.width / 20;

	this.getCanvas = function() {
		return this.canvas;
	}

	this.drawGrid = function() {
		this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);

		this.context.beginPath();
		this.context.strokeStyle = "red";

		let currentX = 0;
		let currentY = 0;

		while(currentX < this.canvas.width) {
			while(currentY < this.canvas.height) {
				this.context.rect(currentX, currentY, this.gridWidth, this.gridHeight);
				currentY += this.gridHeight;
			}
			currentY = 0;
			currentX += this.gridWidth;
		}

		this.context.stroke();
	}

	this.canvasResize = function() {
		this.canvas.width = window.innerWidth / 2;
		this.canvas.height = window.innerHeight / 2;
		this.gridHeight = this.canvas.height / 15;
		this.gridWidth = this.canvas.width / 20;

		this.drawGrid();
	}
}