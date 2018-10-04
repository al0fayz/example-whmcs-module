
function drawLine(ctx, startX, startY, endX, endY,color){
    ctx.save();
    ctx.strokeStyle = color;
    ctx.beginPath();
    ctx.moveTo(startX,startY);
    ctx.lineTo(endX,endY);
    ctx.stroke();
    ctx.restore();
}

function drawBar(ctx, upperLeftCornerX, upperLeftCornerY, width, height,color){
    ctx.save();
    ctx.fillStyle=color;
    ctx.fillRect(upperLeftCornerX,upperLeftCornerY,width,height);
    ctx.restore();
}
var Barchart = function(options){
    this.options = options;
    this.canvas = options.canvas;
    this.ctx = this.canvas.getContext("2d");
    this.colors = options.colors;

    this.draw = function(){
        var maxValue = 0;
        for (var categ in this.options.data){
            // maxValue = Math.max(maxValue,this.options.data[categ]);
                if( this.options.data.hasOwnProperty( categ ) ) {
                  maxValue += parseFloat( this.options.data[categ] );
              }
      }


      var canvasActualHeight = this.canvas.height - this.options.padding * 2;
      var canvasActualWidth = this.canvas.width;

        //drawing the grid lines
        // var gridValue = 0;
        // while (gridValue <= maxValue){
        //     var gridY = canvasActualHeight * (1 - gridValue/maxValue) + this.options.padding;
        //     drawLine(
        //         this.ctx,
        //         0,
        //         gridY,
        //         this.canvas.width,
        //         gridY,
        //         this.options.gridColor
        //         );

        //     //writing grid markers
        //     this.ctx.save();
        //     this.ctx.fillStyle = this.options.gridColor;
        //     this.ctx.font = "bold 10px Arial";
        //     this.ctx.fillText(gridValue, 10,gridY - 2);
        //     this.ctx.restore();

        //     gridValue+=this.options.gridScale;
        // }

        //drawing the bars
        var barIndex = 0;
        var index = 0;
        var numberOfBars = Object.keys(this.options.data).length;

        for (categ in this.options.data){
            var val = this.options.data[categ];
            var barwidth = Math.round( canvasActualWidth * val/maxValue) ;
            var xwidth = barwidth  -1;
            var barHeight = canvasActualHeight;
            drawBar(
                this.ctx,
                barIndex,
                this.canvas.height - barHeight - this.options.padding,
                barwidth,
                barHeight,
                this.colors[index%this.colors.length]
                );
            index++;
            barIndex += xwidth;
        }
    }
}
function line(cyrcle, startX, startY, endX, endY){
    cyrcle.beginPath();
    cyrcle.moveTo(startX,startY);
    cyrcle.lineTo(endX,endY);
    cyrcle.stroke();
}
function drawArc(cyrcle, centerX, centerY, radius, startAngle, endAngle){
    cyrcle.beginPath();
    cyrcle.arc(centerX, centerY, radius, startAngle, endAngle);
    cyrcle.stroke();
}
function drawCyrcle(cyrcle,centerX, centerY, radius, startAngle, endAngle, color ){
    cyrcle.fillStyle = color;
    cyrcle.beginPath();
    cyrcle.moveTo(centerX,centerY);
    cyrcle.arc(centerX, centerY, radius, startAngle, endAngle);
    cyrcle.closePath();
    cyrcle.fill();
}