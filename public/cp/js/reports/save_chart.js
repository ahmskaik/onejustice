

EXPORT_WIDTH = 1200;

function save_chart(chart) {
    var render_width = EXPORT_WIDTH;
    var render_height = render_width * chart.chartHeight / chart.chartWidth

    // Get the cart's SVG code
    var svg = chart.getSVG({
        exporting: {
            sourceWidth: chart.chartWidth,
            sourceHeight: chart.chartHeight
        }
    });

    // Create a canvas
    var canvas = document.createElement('canvas');
    canvas.height = render_height;
    canvas.width = render_width;
    //document.body.appendChild(canvas);

    // Create an image and draw the SVG onto the canvas
    var image = new Image;
    image.onload = function() {
        canvas.getContext('2d').drawImage(this, 0, 0, render_width, render_height);
    };
    //return image.src = 'data:image/svg+xml;base64,' + window.btoa(svg);
    return image.src = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svg)));
}
window.save_chart = save_chart;