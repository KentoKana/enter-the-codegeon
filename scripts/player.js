function Player(widthInTiles, heightInTiles, xPosition=0, yPosition=0) {
	this.xPosition = xPosition;
	this.yPosition = yPosition;

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