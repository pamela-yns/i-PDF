@extends('layouts.app')

@section('content')
<div x-data="{ loginModal: false, registerModal: false }" class="min-h-screen flex flex-col items-center bg-gradient-to-br from-indigo-50 to-white">
    <div class="max-w-xl w-full text-center space-y-8">
        <div>
            <svg class="mx-auto w-16 h-16 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 15s1.5-2 4-2 4 2 4 2" />
                <circle cx="12" cy="10" r="3" />
            </svg>
            <h1 class="mt-4 text-4xl font-extrabold text-gray-800">i-PDF</h1>
            <p class="mt-2 text-lg text-gray-500">Edit, annotate, and save your PDFs and blank canvases. Access your work anywhere, anytime.</p>
        </div>
        <div class="flex justify-center space-x-4">
            <button @click="loginModal = true" class="px-6 py-2 bg-indigo-500 text-white rounded-lg font-semibold hover:bg-indigo-600 transition">Login</button>
            <button @click="registerModal = true" class="px-6 py-2 bg-white border border-indigo-500 text-indigo-500 rounded-lg font-semibold hover:bg-indigo-50 transition">Register</button>
        </div>
        <div class="mt-8 text-gray-400 text-sm">
            <span>Secure. Fast. Free.</span>
        </div>
    </div>

    <!-- Canvas Editor Section -->
    <div class="w-full flex flex-col items-center mt-12 mb-16">
        <div class="mb-4 w-full flex flex-col items-center space-y-2">
            <div class="flex justify-center space-x-2">
                <button id="addTextBtn" class="px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600 transition">Add Text</button>
                <button id="addShapeBtn" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition">Add Shape</button>
                <label class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition cursor-pointer">
                    Add Image
                    <input type="file" id="addImageInput" accept="image/*" class="hidden" />
                </label>
                <button id="deleteBtn" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">Delete Selected</button>
            </div>
            <div class="flex justify-center space-x-2">
                <button id="addPageBtn" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">Add Page</button>
                <button id="prevPageBtn" class="px-4 py-2 bg-blue-400 text-white rounded hover:bg-blue-500 transition">Previous</button>
                <span id="pageIndicator" class="px-2 py-2 text-gray-700 font-semibold">Page 1</span>
                <span id="totalPagesLabel" class="px-2 py-2 text-gray-500">/ 1</span>
                <button id="nextPageBtn" class="px-4 py-2 bg-blue-400 text-white rounded hover:bg-blue-500 transition">Next</button>
                <span class="flex-1"></span>
                <select id="pdfSizeSelect" class="px-2 py-2 border rounded text-sm">
                    <option value="auto">Auto Size</option>
                    <option value="a4">A4 (210×297mm)</option>
                    <option value="letter">Letter (216×279mm)</option>
                    <option value="legal">Legal (216×356mm)</option>
                    <option value="a3">A3 (297×420mm)</option>
                </select>
                <button id="exportPdfBtn" class="px-4 py-2 bg-purple-500 text-white rounded hover:bg-purple-600 transition">Export PDF</button>
            </div>
            <div class="flex justify-center items-center space-x-2 w-full">
                <label class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition cursor-pointer">
                    Upload PDF
                    <input type="file" id="uploadPdfInput" accept=".pdf" class="hidden" />
                </label>
                <span class="text-gray-500 text-sm">or Start with a blank canvas</span>
                <input type="color" id="canvasBgColor" value="#ffffff" class="w-8 h-8 p-0 border-0 rounded" title="Canvas background color" />
            </div>
        </div>
        <div id="canvasPages" class="w-full flex flex-col items-center"></div>
    </div>

    <!-- Shape Modal -->
    <div id="shapeModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40" style="display:none;">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-xs p-6 relative">
            <button id="closeShapeModal" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            <h3 class="text-lg font-bold mb-4">Add Shape</h3>
            <form id="shapeForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Shape</label>
                    <select id="shapeType" class="w-full border rounded px-2 py-1">
                        <option value="rect">Rectangle</option>
                        <option value="circle">Circle</option>
                        <option value="ellipse">Ellipse</option>
                        <option value="triangle">Triangle</option>
                        <option value="polygon">Polygon</option>
                        <option value="star">Star</option>
                        <option value="line">Line</option>
                        <option value="arrow">Arrow</option>
                        <option value="x">X (Cross)</option>
                        <option value="check">Checkmark</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Style</label>
                    <select id="shapeStyle" class="w-full border rounded px-2 py-1">
                        <option value="filled">Filled</option>
                        <option value="outlined">Outlined</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Color</label>
                    <input type="color" id="shapeColor" value="#10b981" class="w-12 h-8 p-0 border-0" />
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Outline Width</label>
                    <input type="range" id="outlineWidth" min="1" max="20" value="3" class="w-full" />
                    <span id="outlineWidthValue" class="text-sm text-gray-600">3px</span>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition">Add</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Text Formatting Toolbar -->
    <div id="textToolbar" class="fixed bg-white border border-gray-300 rounded-lg shadow-lg p-2 z-40" style="display:none;">
        <div class="flex items-center space-x-2">
            <select id="fontFamily" class="border rounded px-2 py-1 text-sm">
                <option value="Arial">Arial</option>
                <option value="Times New Roman">Times New Roman</option>
                <option value="Courier New">Courier New</option>
                <option value="Georgia">Georgia</option>
                <option value="Verdana">Verdana</option>
                <option value="Helvetica">Helvetica</option>
                <option value="Comic Sans MS">Comic Sans MS</option>
            </select>
            <input type="number" id="fontSize" min="8" max="72" value="24" class="w-16 border rounded px-2 py-1 text-sm" />
            <input type="color" id="fontColor" value="#333333" class="w-8 h-8 p-0 border-0" />
            <button id="boldBtn" class="px-2 py-1 border rounded text-sm hover:bg-gray-100">B</button>
            <button id="italicBtn" class="px-2 py-1 border rounded text-sm hover:bg-gray-100 italic">I</button>
            <button id="underlineBtn" class="px-2 py-1 border rounded text-sm hover:bg-gray-100 underline">U</button>
        </div>
    </div>

    <!-- Shape Formatting Tooltip -->
    <div id="shapeTooltip" class="fixed bg-white border border-gray-300 rounded-lg shadow-lg p-2 z-40" style="display:none;">
        <div class="flex items-center space-x-2">
            <div>
                <label class="block text-xs font-medium mb-1">Stroke</label>
                <input type="color" id="shapeOutlineColor" value="#10b981" class="w-6 h-6 p-0 border-0" />
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Width</label>
                <input type="range" id="shapeOutlineWidth" min="1" max="20" value="3" class="w-12" />
                <span id="shapeOutlineWidthValue" class="text-xs text-gray-600">3px</span>
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Fill</label>
                <input type="color" id="shapeFillColor" value="#10b981" class="w-6 h-6 p-0 border-0" />
            </div>
            <button id="saveShapeBtn" class="px-2 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600">Save</button>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Multi-page canvas logic
        var pages = [];
        var currentPage = 1;
        var pdfMode = false;
        var canvasPages = document.getElementById('canvasPages');
        
        // Get DOM elements for tooltips
        var textToolbar = document.getElementById('textToolbar');
        var shapeTooltip = document.getElementById('shapeTooltip');

        function createCanvasContainer(pageNum, width = 800, height = 1000) {
            var container = document.createElement('div');
            container.className = 'canvas-container';
            container.id = pageNum.toString();
            container.style.display = 'none';
            var c = document.createElement('canvas');
            c.width = width;
            c.height = height;
            c.className = 'border border-gray-300 rounded-lg shadow';
            container.appendChild(c);
            canvasPages.appendChild(container);
            var fabricCanvas = new fabric.Canvas(c);
            
            // Set up canvas events for the new canvas
            setupCanvasEvents(fabricCanvas);
            
            return { container, fabricCanvas };
        }

        function showPage(pageNum) {
            // Hide tooltips when switching pages
            hideTextToolbar();
            hideShapeTooltip();
            
            pages.forEach(function(p, idx) {
                p.container.style.display = (idx + 1 === pageNum) ? '' : 'none';
            });
            currentPage = pageNum;
            updatePageLabels();
        }

        // Initial blank page
        function initBlank() {
            pages = [];
            canvasPages.innerHTML = '';
            // Clear original page sizes when starting blank
            window.originalPageSizes = [];
            var page = createCanvasContainer(1);
            pages.push(page);
            showPage(1);
        }
        initBlank();

        // Update page indicator and total pages label
        function updatePageLabels() {
            document.getElementById('pageIndicator').textContent = 'Page ' + currentPage;
            document.getElementById('totalPagesLabel').textContent = '/ ' + pages.length;
        }
        // Call updatePageLabels in showPage and after addPage/upload
        document.getElementById('addPageBtn').onclick = function() {
            var width = pages[0].fabricCanvas.getWidth();
            var height = pages[0].fabricCanvas.getHeight();
            
            // Insert new page after current page
            var newPageNum = currentPage + 1;
            var page = createCanvasContainer(newPageNum, width, height);
            
            // Insert the new page at the correct position
            pages.splice(currentPage, 0, page);
            
            // Update IDs for all pages after the inserted page
            for (var i = currentPage; i < pages.length; i++) {
                pages[i].container.id = (i + 1).toString();
            }
            
            // Show the newly inserted page
            showPage(newPageNum);
            updatePageLabels();
        };
        document.getElementById('prevPageBtn').onclick = function() {
            if (currentPage > 1) showPage(currentPage - 1);
        };
        document.getElementById('nextPageBtn').onclick = function() {
            if (currentPage < pages.length) showPage(currentPage + 1);
        };

        // Toolbar actions use the current page's fabricCanvas
        function getCurrentCanvas() { return pages[currentPage - 1].fabricCanvas; }

        document.getElementById('addTextBtn').onclick = function() {
            var text = new fabric.IText('Double-click to edit', {
                left: 100, top: 100, fontSize: 24, fill: '#333'
            });
            getCurrentCanvas().add(text).setActiveObject(text);
            setTimeout(function() {
                showTextToolbar(text);
            }, 50);
        };
        document.getElementById('addShapeBtn').onclick = function() {
            document.getElementById('shapeModal').style.display = 'flex';
        };
        document.getElementById('closeShapeModal').onclick = function() {
            document.getElementById('shapeModal').style.display = 'none';
        };
        document.getElementById('outlineWidth').oninput = function() {
            document.getElementById('outlineWidthValue').textContent = this.value + 'px';
        };
        document.getElementById('shapeForm').onsubmit = function(e) {
            e.preventDefault();
            var type = document.getElementById('shapeType').value;
            var style = document.getElementById('shapeStyle').value;
            var color = document.getElementById('shapeColor').value;
            var outlineWidth = parseInt(document.getElementById('outlineWidth').value);
            var shape;
            if (type === 'rect') {
                shape = new fabric.Rect({
                    left: 150, top: 150, width: 100, height: 60, rx: 8, ry: 8,
                    fill: style === 'filled' ? color : 'transparent',
                    stroke: style === 'outlined' ? color : undefined,
                    strokeWidth: style === 'outlined' ? outlineWidth : 0
                });
            } else if (type === 'circle') {
                shape = new fabric.Circle({
                    left: 200, top: 200, radius: 40,
                    fill: style === 'filled' ? color : 'transparent',
                    stroke: style === 'outlined' ? color : undefined,
                    strokeWidth: style === 'outlined' ? outlineWidth : 0
                });
            } else if (type === 'ellipse') {
                shape = new fabric.Ellipse({
                    left: 250, top: 200, rx: 60, ry: 30,
                    fill: style === 'filled' ? color : 'transparent',
                    stroke: style === 'outlined' ? color : undefined,
                    strokeWidth: style === 'outlined' ? outlineWidth : 0
                });
            } else if (type === 'triangle') {
                shape = new fabric.Triangle({
                    left: 250, top: 250, width: 80, height: 80,
                    fill: style === 'filled' ? color : 'transparent',
                    stroke: style === 'outlined' ? color : undefined,
                    strokeWidth: style === 'outlined' ? outlineWidth : 0
                });
            } else if (type === 'polygon') {
                shape = new fabric.Polygon([
                    {x: 0, y: -30}, {x: 20, y: -10}, {x: 30, y: 20},
                    {x: 10, y: 30}, {x: -10, y: 30}, {x: -30, y: 20},
                    {x: -20, y: -10}
                ], {
                    left: 300, top: 250,
                    fill: style === 'filled' ? color : 'transparent',
                    stroke: style === 'outlined' ? color : undefined,
                    strokeWidth: style === 'outlined' ? outlineWidth : 0
                });
            } else if (type === 'star') {
                shape = new fabric.Polygon([
                    {x: 0, y: -30}, {x: 8, y: -8}, {x: 30, y: -8},
                    {x: 12, y: 8}, {x: 20, y: 30}, {x: 0, y: 20},
                    {x: -20, y: 30}, {x: -12, y: 8}, {x: -30, y: -8}, {x: -8, y: -8}
                ], {
                    left: 350, top: 250,
                    fill: style === 'filled' ? color : 'transparent',
                    stroke: style === 'outlined' ? color : undefined,
                    strokeWidth: style === 'outlined' ? outlineWidth : 0
                });
            } else if (type === 'line') {
                shape = new fabric.Line([300, 300, 400, 400], {
                    stroke: color,
                    strokeWidth: outlineWidth
                });
            } else if (type === 'arrow') {
                shape = new fabric.Path('M 0 0 L 60 0 L 50 -10 M 60 0 L 50 10', {
                    left: 400, top: 300,
                    stroke: color,
                    strokeWidth: outlineWidth,
                    fill: 'transparent'
                });
            } else if (type === 'x') {
                shape = new fabric.Path('M 10 10 L 50 50 M 50 10 L 10 50', {
                    left: 450, top: 300,
                    stroke: color,
                    strokeWidth: outlineWidth,
                    fill: 'transparent'
                });
            } else if (type === 'check') {
                shape = new fabric.Path('M 10 30 L 25 45 L 50 15', {
                    left: 500, top: 300,
                    stroke: color,
                    strokeWidth: outlineWidth,
                    fill: 'transparent'
                });
            }
            getCurrentCanvas().add(shape).setActiveObject(shape);
            document.getElementById('shapeModal').style.display = 'none';
        };
        document.getElementById('addImageInput').onchange = function(e) {
            var file = e.target.files[0];
            if (!file) return;
            var reader = new FileReader();
            reader.onload = function(f) {
                fabric.Image.fromURL(f.target.result, function(img) {
                    img.set({ left: 250, top: 150, scaleX: 0.5, scaleY: 0.5 });
                    getCurrentCanvas().add(img).setActiveObject(img);
                });
            };
            reader.readAsDataURL(file);
            e.target.value = '';
        };
        document.getElementById('deleteBtn').onclick = function() {
            var active = getCurrentCanvas().getActiveObject();
            if (active) {
                getCurrentCanvas().remove(active);
            }
        };
        document.getElementById('exportPdfBtn').onclick = function() {
            var { jsPDF } = window.jspdf;
            var sizeOption = document.getElementById('pdfSizeSelect').value;
            
            // Define standard page sizes in mm
            var pageSizes = {
                'a4': [210, 297],
                'letter': [216, 279],
                'legal': [216, 356],
                'a3': [297, 420]
            };
            
            var pdfWidth, pdfHeight;
            
            if (sizeOption === 'auto') {
                // Check if we have original PDF page sizes
                if (window.originalPageSizes && window.originalPageSizes.length > 0) {
                    // Use original PDF dimensions
                    var firstPageSize = window.originalPageSizes[0];
                    var orientation = firstPageSize.isLandscape ? 'l' : 'p'; // 'l' for landscape, 'p' for portrait
                    var pdf = new jsPDF(orientation, 'mm', [firstPageSize.width, firstPageSize.height]);
                    
            pages.forEach(function(page, idx) {
                        if (idx > 0) {
                            // Use original size for each page if available
                            var pageSize = window.originalPageSizes[idx] || window.originalPageSizes[0];
                            pdf.addPage([pageSize.width, pageSize.height]);
                        }
                        
                var dataURL = page.fabricCanvas.toDataURL({ format: 'png', quality: 1 });
                        
                        // Use original page dimensions
                        var pageSize = window.originalPageSizes[idx] || window.originalPageSizes[0];
                        var imgWidth = pageSize.width;
                        var imgHeight = pageSize.height;
                        
                pdf.addImage(dataURL, 'PNG', 0, 0, imgWidth, imgHeight);
            });
                } else {
                    // Fallback to content-based sizing for blank canvases
                    var pdfPages = [];
                    pages.forEach(function(page, idx) {
                        var canvas = page.fabricCanvas;
                        
                        // Get the actual content bounds
                        var objects = canvas.getObjects();
                        var minX = 0, minY = 0, maxX = canvas.width, maxY = canvas.height;
                        
                        if (objects.length > 0) {
                            // Calculate bounds of all objects
                            var bounds = canvas.getObjects().reduce(function(acc, obj) {
                                var objBounds = obj.getBoundingRect();
                                return {
                                    minX: Math.min(acc.minX, objBounds.left),
                                    minY: Math.min(acc.minY, objBounds.top),
                                    maxX: Math.max(acc.maxX, objBounds.left + objBounds.width),
                                    maxY: Math.max(acc.maxY, objBounds.top + objBounds.height)
                                };
                            }, { minX: Infinity, minY: Infinity, maxX: -Infinity, maxY: -Infinity });
                            
                            // Add some padding
                            var padding = 20;
                            minX = Math.max(0, bounds.minX - padding);
                            minY = Math.max(0, bounds.minY - padding);
                            maxX = Math.min(canvas.width, bounds.maxX + padding);
                            maxY = Math.min(canvas.height, bounds.maxY + padding);
                        }
                        
                        var contentWidth = maxX - minX;
                        var contentHeight = maxY - minY;
                        
                        // Ensure minimum dimensions
                        contentWidth = Math.max(contentWidth, 200);
                        contentHeight = Math.max(contentHeight, 200);
                        
                        pdfPages.push({
                            dataURL: canvas.toDataURL({ format: 'png', quality: 1 }),
                            width: contentWidth,
                            height: contentHeight,
                            minX: minX,
                            minY: minY
                        });
                    });
                    
                    // Find the maximum dimensions to use consistent page size
                    var maxWidth = Math.max(...pdfPages.map(p => p.width));
                    var maxHeight = Math.max(...pdfPages.map(p => p.height));
                    
                    // Convert to mm (assuming 96 DPI)
                    var mmPerPixel = 25.4 / 96;
                    pdfWidth = maxWidth * mmPerPixel;
                    pdfHeight = maxHeight * mmPerPixel;
                    
                    // Ensure reasonable limits
                    pdfWidth = Math.min(Math.max(pdfWidth, 50), 420); // Max A3 width
                    pdfHeight = Math.min(Math.max(pdfHeight, 50), 594); // Max A3 height
                    
                    // Create PDF with calculated dimensions
                    var pdf = new jsPDF('p', 'mm', [pdfWidth, pdfHeight]);
                    
                    pdfPages.forEach(function(page, idx) {
                        if (idx > 0) pdf.addPage();
                        
                        // Scale the image to fit the PDF page
                        var scaleX = pdfWidth / page.width;
                        var scaleY = pdfHeight / page.height;
                        var scale = Math.min(scaleX, scaleY, 1); // Don't scale up
                        
                        var imgWidth = page.width * scale * mmPerPixel;
                        var imgHeight = page.height * scale * mmPerPixel;
                        
                        // Center the image on the page
                        var x = (pdfWidth - imgWidth) / 2;
                        var y = (pdfHeight - imgHeight) / 2;
                        
                        pdf.addImage(page.dataURL, 'PNG', x, y, imgWidth, imgHeight);
                    });
                }
            } else {
                // Use standard page size
                var size = pageSizes[sizeOption];
                pdfWidth = size[0];
                pdfHeight = size[1];
                
                // Check if we should use landscape orientation for standard sizes
                var orientation = 'p'; // Default to portrait
                if (window.originalPageSizes && window.originalPageSizes.length > 0) {
                    // If we have original PDF data, use the first page's orientation
                    var firstPageSize = window.originalPageSizes[0];
                    orientation = firstPageSize.isLandscape ? 'l' : 'p';
                }
                
                var pdf = new jsPDF(orientation, 'mm', [pdfWidth, pdfHeight]);
                
                pages.forEach(function(page, idx) {
                    if (idx > 0) pdf.addPage();
                    
                    var dataURL = page.fabricCanvas.toDataURL({ format: 'png', quality: 1 });
                    
                    // Scale to fit the standard page size
                    var imgWidth = pdfWidth;
                    var imgHeight = (page.fabricCanvas.height * imgWidth) / page.fabricCanvas.width;
                    
                    // If height exceeds page height, scale down
                    if (imgHeight > pdfHeight) {
                        imgHeight = pdfHeight;
                        imgWidth = (page.fabricCanvas.width * imgHeight) / page.fabricCanvas.height;
                    }
                    
                    // Center the image on the page
                    var x = (pdfWidth - imgWidth) / 2;
                    var y = (pdfHeight - imgHeight) / 2;
                    
                    pdf.addImage(dataURL, 'PNG', x, y, imgWidth, imgHeight);
                });
            }
            
            pdf.save('canvas-export.pdf');
        };
        document.getElementById('uploadPdfInput').onchange = function(e) {
            var file = e.target.files[0];
            if (!file) return;
            var reader = new FileReader();
            reader.onload = function(event) {
                var typedarray = new Uint8Array(event.target.result);
                pdfjsLib.getDocument(typedarray).promise.then(function(pdf) {
                    pages = [];
                    canvasPages.innerHTML = '';
                    var loadPages = [];
                    var originalPageSizes = []; // Store original PDF page sizes
                    
                    for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                        loadPages.push(pdf.getPage(pageNum).then(function(page) {
                            var viewport = page.getViewport({scale: 1.5});
                            
                            // Store original page dimensions (in points, 1 point = 1/72 inch)
                            var originalWidth = page.view[2] - page.view[0]; // Width in points
                            var originalHeight = page.view[3] - page.view[1]; // Height in points
                            
                            // Convert points to mm (1 point = 0.352777778 mm)
                            var mmPerPoint = 0.352777778;
                            var widthMm = originalWidth * mmPerPoint;
                            var heightMm = originalHeight * mmPerPoint;
                            
                            originalPageSizes.push({
                                width: widthMm,
                                height: heightMm,
                                isLandscape: widthMm > heightMm
                            });
                            
                            var pageObj = createCanvasContainer(pageNum, viewport.width, viewport.height);
                            pages.push(pageObj);
                            var pdfCanvas = document.createElement('canvas');
                            var pdfContext = pdfCanvas.getContext('2d');
                            pdfCanvas.height = viewport.height;
                            pdfCanvas.width = viewport.width;
                            var renderContext = {
                                canvasContext: pdfContext,
                                viewport: viewport
                            };
                            page.render(renderContext).promise.then(function() {
                                fabric.Image.fromURL(pdfCanvas.toDataURL(), function(img) {
                                    img.set({
                                        left: 0,
                                        top: 0,
                                        selectable: false,
                                        evented: false
                                    });
                                    pageObj.fabricCanvas.add(img);
                                    pageObj.fabricCanvas.sendToBack(img);
                                    pageObj.fabricCanvas.renderAll();
                                });
                            });
                        }));
                    }
                    Promise.all(loadPages).then(function() {
                        // Store original page sizes globally for export
                        window.originalPageSizes = originalPageSizes;
                        showPage(1);
                        updatePageLabels();
                    });
                }).catch(function(error) {
                    console.error('Error loading PDF:', error);
                    alert('Error loading PDF. Please try again.');
                });
            };
            reader.readAsArrayBuffer(file);
            e.target.value = '';
        };
        // Canvas background color picker
        document.getElementById('canvasBgColor').oninput = function() {
            var color = this.value;
            getCurrentCanvas().setBackgroundColor(color, getCurrentCanvas().renderAll.bind(getCurrentCanvas()));
        };
        // Set default background color
        getCurrentCanvas().setBackgroundColor('#ffffff', getCurrentCanvas().renderAll.bind(getCurrentCanvas()));

        // Text formatting functionality
        var currentTextObject = null;

        function showTextToolbar(obj) {
            console.log("obj type text: ", obj.type === 'i-text')
            if (obj && obj.type === 'i-text' && textToolbar) {
                currentTextObject = obj;
                var canvas = getCurrentCanvas(); // Use the current page's canvas
                var rect = obj.getBoundingRect();
                var zoom = canvas.getZoom();
                var vpt = canvas.viewportTransform;
                
                // Get canvas element position
                var canvasEl = canvas.getElement();
                var canvasRect = canvasEl.getBoundingClientRect();
                
                var left = canvasRect.left + (rect.left * zoom + vpt[4]) + 10;
                var top = canvasRect.top + (rect.top * zoom + vpt[5]) - 50;
                
                textToolbar.style.left = left + 'px';
                textToolbar.style.top = top + 'px';
                textToolbar.style.display = 'block';
                
                // Set current values
                document.getElementById('fontFamily').value = obj.fontFamily || 'Arial';
                document.getElementById('fontSize').value = obj.fontSize || 24;
                document.getElementById('fontColor').value = obj.fill || '#333333';
                document.getElementById('boldBtn').classList.toggle('bg-blue-200', obj.fontWeight === 'bold');
                document.getElementById('italicBtn').classList.toggle('bg-blue-200', obj.fontStyle === 'italic');
                document.getElementById('underlineBtn').classList.toggle('bg-blue-200', obj.underline);
            }
        }

        function hideTextToolbar() {
            if (textToolbar) {
            textToolbar.style.display = 'none';
            }
            currentTextObject = null;
        }

        function saveTextChanges() {
            if (currentTextObject) {
                // Changes are already applied in real-time, just ensure canvas is rendered
                getCurrentCanvas().renderAll();
                hideTextTooltip();
            }
        }

        function hideTextTooltip() {
            textToolbar.style.display = 'none';
            currentTextObject = null;
        }

        // Event listeners for text formatting
        document.getElementById('fontFamily').onchange = function() {
            if (currentTextObject) {
                currentTextObject.set('fontFamily', this.value);
                getCurrentCanvas().renderAll();
            }
        };

        document.getElementById('fontSize').onchange = function() {
            if (currentTextObject) {
                currentTextObject.set('fontSize', parseInt(this.value));
                getCurrentCanvas().renderAll();
            }
        };

        document.getElementById('fontColor').onchange = function() {
            if (currentTextObject) {
                currentTextObject.set('fill', this.value);
                getCurrentCanvas().renderAll();
            }
        };

        document.getElementById('boldBtn').onclick = function() {
            if (currentTextObject) {
                var isBold = currentTextObject.fontWeight === 'bold';
                currentTextObject.set('fontWeight', isBold ? 'normal' : 'bold');
                this.classList.toggle('bg-blue-200');
                getCurrentCanvas().renderAll();
            }
        };

        document.getElementById('italicBtn').onclick = function() {
            if (currentTextObject) {
                var isItalic = currentTextObject.fontStyle === 'italic';
                currentTextObject.set('fontStyle', isItalic ? 'normal' : 'italic');
                this.classList.toggle('bg-blue-200');
                getCurrentCanvas().renderAll();
            }
        };

        document.getElementById('underlineBtn').onclick = function() {
            if (currentTextObject) {
                var isUnderlined = currentTextObject.underline;
                currentTextObject.set('underline', !isUnderlined);
                this.classList.toggle('bg-blue-200');
                getCurrentCanvas().renderAll();
            }
        };

        // Shape formatting functionality
        var currentShapeObject = null;

        function showShapeTooltip(obj) {
            if (obj && obj.type !== 'i-text' && shapeTooltip) {
                currentShapeObject = obj;
                var canvas = getCurrentCanvas(); // Use the current page's canvas
                var rect = obj.getBoundingRect();
                var zoom = canvas.getZoom();
                var vpt = canvas.viewportTransform;
                
                // Get canvas element position
                var canvasEl = canvas.getElement();
                var canvasRect = canvasEl.getBoundingClientRect();
                
                // Position tooltip to the right of the shape, not covering it
                var left = canvasRect.left + (rect.left * zoom + vpt[4]) + rect.width * zoom + 20;
                var top = canvasRect.top + (rect.top * zoom + vpt[5]) - 30;
                
                // Ensure tooltip doesn't go off-screen
                var tooltipWidth = 200; // Approximate tooltip width
                if (left + tooltipWidth > window.innerWidth) {
                    left = canvasRect.left + (rect.left * zoom + vpt[4]) - tooltipWidth - 10;
                }
                
                shapeTooltip.style.left = left + 'px';
                shapeTooltip.style.top = top + 'px';
                shapeTooltip.style.display = 'block';
                
                // Set current values
                document.getElementById('shapeOutlineColor').value = obj.stroke || '#10b981';
                document.getElementById('shapeOutlineWidth').value = obj.strokeWidth || 3;
                document.getElementById('shapeFillColor').value = obj.fill || '#10b981';
                document.getElementById('shapeOutlineWidthValue').textContent = (obj.strokeWidth || 3) + 'px';
            }
        }

        function saveShapeChanges() {
            if (currentShapeObject) {
                // Changes are already applied in real-time, just ensure canvas is rendered
                getCurrentCanvas().renderAll();
                hideShapeTooltip();
            }
        }

        function hideShapeTooltip() {
            if (shapeTooltip) {
            shapeTooltip.style.display = 'none';
            }
            currentShapeObject = null;
        }

        // Event listeners for shape formatting
        document.getElementById('shapeOutlineColor').onchange = function() {
            if (currentShapeObject) {
                currentShapeObject.set('stroke', this.value);
                getCurrentCanvas().renderAll();
            }
        };

        document.getElementById('shapeOutlineWidth').oninput = function() {
            if (currentShapeObject) {
                currentShapeObject.set('strokeWidth', parseInt(this.value));
                document.getElementById('shapeOutlineWidthValue').textContent = this.value + 'px';
                getCurrentCanvas().renderAll();
            }
        };

        document.getElementById('shapeFillColor').onchange = function() {
            if (currentShapeObject) {
                currentShapeObject.set('fill', this.value);
                getCurrentCanvas().renderAll();
            }
        };

        document.getElementById('saveShapeBtn').onclick = function() {
            saveShapeChanges();
        };

        // Update canvas events to handle shape selection
        function setupCanvasEvents(canvas) {
            console.log('Setting up canvas events for canvas:', canvas);
            
            canvas.on('object:selected', function(e) {
                console.log('Object selected:', e.target);
                if (e.target && e.target.type === 'i-text') {
                    console.log('Text object selected, showing toolbar');
                    showTextToolbar(e.target);
                    hideShapeTooltip();
                } else if (e.target) {
                    console.log('Shape object selected, showing tooltip');
                    showShapeTooltip(e.target);
                    hideTextToolbar();
                }
            });

            canvas.on('selection:created', function(e) {
                console.log('Selection created, active object:', canvas.getActiveObject());
                var activeObj = canvas.getActiveObject();
                if (activeObj && activeObj.type === 'i-text') {
                    console.log('Text selected, showing toolbar', activeObj);
                    showTextToolbar(activeObj);
                    hideShapeTooltip();
                } else if (activeObj) {
                    console.log('Shape selected, showing tooltip');
                    showShapeTooltip(activeObj);
                    hideTextToolbar();
                }
            });

            canvas.on('selection:updated', function(e) {
                console.log('Selection updated, active object:', canvas.getActiveObject());
                var activeObj = canvas.getActiveObject();
                if (activeObj && activeObj.type === 'i-text') {
                    console.log('Text selected, showing toolbar');
                    showTextToolbar(activeObj);
                    hideShapeTooltip();
                } else if (activeObj) {
                    console.log('Shape selected, showing tooltip');
                    showShapeTooltip(activeObj);
                    hideTextToolbar();
                }
            });

            canvas.on('selection:cleared', function() {
                console.log('Selection cleared');
                // Only hide if no object is currently active
                var activeObj = canvas.getActiveObject();
                if (!activeObj) {
                    hideTextToolbar();
                    hideShapeTooltip();
                }
            });

            // Handle object movement
            canvas.on('object:modified', function(e) {
                console.log('Object modified:', e.target);
                var obj = e.target;
                if (obj) {
                    // Close current tooltips
                    hideTextToolbar();
                    hideShapeTooltip();
                    
                    // Reopen tooltip at new position
                    setTimeout(function() {
                        if (obj.type === 'i-text') {
                            showTextToolbar(obj);
                        } else {
                            showShapeTooltip(obj);
                        }
                    }, 100); // Small delay to ensure object is fully positioned
                }
            });

            // Handle object moving (during drag)
            canvas.on('object:moving', function(e) {
                var obj = e.target;
                if (obj) {
                    // Hide tooltips during movement
                    if (obj.type === 'i-text') {
                        hideTextToolbar();
                    } else {
                        hideShapeTooltip();
                    }
                }
            });
        }

        // Setup events for the initial canvas
        setupCanvasEvents(getCurrentCanvas());

        // Hide toolbar when clicking outside
        document.addEventListener('click', function(e) {
            // Don't hide if clicking inside the toolbars
            if ((textToolbar && textToolbar.contains(e.target)) || (shapeTooltip && shapeTooltip.contains(e.target))) {
                return;
            }
            
            // Don't hide if clicking on the canvas (might be selecting objects)
            if (e.target.closest('#fabricCanvas') || e.target.closest('.canvas-container')) {
                return;
            }
            
            // Save changes and hide tooltips
            if (currentShapeObject) {
                saveShapeChanges();
            } else if (currentTextObject) {
                saveTextChanges();
            } else {
                hideTextToolbar();
            }
        });
    });
    </script>
    
    <!-- Login Modal -->
    <div x-show="loginModal" x-cloak class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40">
        <div @click.away="loginModal = false" class="bg-white rounded-xl shadow-lg w-full max-w-md p-8 relative">
            <button @click="loginModal = false" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            @include('auth._login_form')
        </div>
    </div>
    <!-- Register Modal -->
    <div x-show="registerModal" x-cloak class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40">
        <div @click.away="registerModal = false" class="bg-white rounded-xl shadow-lg w-full max-w-md p-8 relative">
            <button @click="registerModal = false" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            @include('auth._register_form')
        </div>
    </div>
</div>
@endsection 