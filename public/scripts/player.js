"use strict";

function Player(widthInTiles, heightInTiles, xPosition=0, yPosition=0) {
	this.xPosition = xPosition;
	this.yPosition = yPosition;

    this.width = 64;
    this.height = 64;
    this.spriteSheetY = 2;
    this.spriteSheetLocations = [0, 192, 128, 64];
    this.currFrame = 0;
    this.animationFrames = [0, 64, 128, 192, 256, 320, 384, 448, 512];
    this.playerImage = new Image();
    this.playerImage.src = "public/images/archer.png";

	// 0 = up, 1=right, 2=down, 3=left
	this.move = function(direction) {
		switch(direction) {
			case "0":
				if(this.yPosition > 0) {
					this.yPosition--;
				}
				break;
			case "1":
				if(this.xPosition < widthInTiles - 1) {
					this.xPosition++;
				}
				break;
			case "2":
				if(this.yPosition < heightInTiles - 1) {
					this.yPosition++;
				}
				break;
			case "3":
				if(this.xPosition > 0) {
					this.xPosition--;
				}
				break;
		}
	}
}
