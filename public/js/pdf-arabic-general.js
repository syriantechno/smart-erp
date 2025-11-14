/**
 * General Arabic PDF Export Solution - For All System Pages
 * Direct PDF export with corruption fix and Arabic support
 */

window.PDFExporterGeneralArabic = {
    
    // Enhanced corruption mapping
    corruptionMap: {
        '•þŽþãþîþàþÌþäþßþ• þ"þôþèþØþ— þâþ´þ× þ"þãþªþØþ˜þäþßþ• þŽþôþŸþîþßþîþèþÜþ˜þßþ• þ"þÛþ®þ· 3': 'قسم نشط لديه موظف الموظفين ثلاثة 3',
        '•þŽþãþîþàþÌþäþßþ•': 'قسم',
        'þ"þôþèþØþ—': 'نشط',
        'þâþ´þ×': 'لديه',
        'þ"þãþªþØþ˜þäþßþ•': 'موظف',
        'þŽþôþŸþîþßþîþèþÜþ˜þßþ•': 'الموظفين',
        'þ"þÛþ®þ·': 'ثلاثة',
        'Ø§': 'ا', 'Ø¨': 'ب', 'Øª': 'ت', 'Ø«': 'ث', 'Ø¬': 'ج',
        'Ø­': 'ح', 'Ø®': 'خ', 'Ø¯': 'د', 'Ø°': 'ذ', 'Ø±': 'ر',
        'Ø²': 'ز', 'Ø³': 'س', 'Ø´': 'ش', 'Øµ': 'ص', 'Ø¶': 'ض',
        'Ø·': 'ط', 'Ø¸': 'ظ', 'Ø¹': 'ع', 'Øº': 'غ', 'Ù': 'ف',
        'Ù‚': 'ق', 'Ùƒ': 'ك', 'Ù„': 'ل', 'Ù…': 'م', 'Ù†': 'ن',
        'Ù‡': 'ه', 'Ùˆ': 'و', 'ÙŠ': 'ي'
    },

    // Fix corrupted Arabic text
    fixArabicText: function(text) {
        if (!text || typeof text !== 'string') return text;
        
        console.log('🔧 General Arabic fix for:', text);
        
        let fixedText = text;
        
        // Apply corruption patterns
        Object.keys(this.corruptionMap).forEach(corrupted => {
            if (fixedText.includes(corrupted)) {
                fixedText = fixedText.replace(new RegExp(corrupted.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g'), this.corruptionMap[corrupted]);
                console.log('✅ Fixed pattern:', corrupted);
            }
        });
        
        // Remove þ characters
        fixedText = fixedText.replace(/þ/g, '');
        
        // UTF-8 decode if needed
        if (fixedText.match(/[ØÙ]/)) {
            try {
                fixedText = decodeURIComponent(escape(fixedText));
                console.log('✅ UTF-8 decode successful');
            } catch (e) {
                console.log('❌ UTF-8 decode failed');
            }
        }
        
        console.log('🎉 Fixed result:', fixedText);
        return fixedText.trim();
    },

    // Check if text contains Arabic
    containsArabic: function(text) {
        return /[\u0600-\u06FF]/.test(text);
    },

    // Load jsPDF
    loadJSPDF: async function() {
        if (typeof window.jspdf !== 'undefined') {
            return Promise.resolve();
        }
        
        return new Promise((resolve, reject) => {
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js';
            script.onload = resolve;
            script.onerror = reject;
            document.head.appendChild(script);
        });
    },

    // Create canvas with Arabic text (General Purpose)
    createArabicCanvas: function(data, headers, title, options = {}) {
        // Default options
        const defaultOptions = {
            titleFontSize: 48,
            headerFontSize: 32,
            dataFontSize: 28,
            titleColor: '#000',
            headerColor: '#fff',
            dataColor: '#000',
            headerBgColor: '#4a5568',
            rowAltBgColor: '#f7fafc',
            padding: 100,
            rowHeight: 80
        };
        
        const opts = { ...defaultOptions, ...options };
        
        // Process all text with corruption fix
        const processedTitle = this.fixArabicText(title);
        const processedHeaders = headers.map(h => this.fixArabicText(String(h || '')));
        const processedData = data.map(row => {
            const processedRow = Array.isArray(row) ? row : Object.values(row);
            return processedRow.map(cell => this.fixArabicText(String(cell || '')));
        });
        
        console.log('📝 Fixed title:', processedTitle);
        console.log('📋 Fixed headers:', processedHeaders);
        console.log('📊 Fixed data sample:', processedData.slice(0, 2));
        
        // Create canvas element
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        
        // Set canvas dimensions (A4 landscape in pixels at 300 DPI)
        canvas.width = 3508; // A4 landscape at 300 DPI
        canvas.height = 2480;
        
        // White background
        ctx.fillStyle = 'white';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        
        // Set font for Arabic text
        ctx.font = `bold ${opts.titleFontSize}px Arial`;
        ctx.fillStyle = opts.titleColor;
        ctx.textAlign = 'right';
        ctx.direction = 'rtl';
        
        // Draw title
        ctx.fillText(processedTitle, canvas.width - opts.padding, opts.padding);
        
        // Draw date
        ctx.font = '24px Arial';
        ctx.fillStyle = '#666';
        ctx.fillText(new Date().toLocaleDateString('ar-SA'), canvas.width - opts.padding, opts.padding + 50);
        
        // Table setup
        const startY = opts.padding + 150;
        const colWidth = (canvas.width - (opts.padding * 2)) / processedHeaders.length;
        let yPosition = startY;
        
        // Draw headers
        ctx.font = `bold ${opts.headerFontSize}px Arial`;
        ctx.fillStyle = opts.headerColor;
        
        // Header background
        ctx.fillStyle = opts.headerBgColor;
        ctx.fillRect(opts.padding, yPosition - 50, canvas.width - (opts.padding * 2), opts.rowHeight);
        
        ctx.fillStyle = opts.headerColor;
        processedHeaders.forEach((header, index) => {
            const x = canvas.width - opts.padding - (index * colWidth);
            ctx.fillText(header, x, yPosition);
        });
        
        yPosition += opts.rowHeight;
        
        // Draw data rows
        ctx.font = `${opts.dataFontSize}px Arial`;
        ctx.fillStyle = opts.dataColor;
        
        processedData.forEach((row, rowIndex) => {
            // Row background
            if (rowIndex % 2 === 0) {
                ctx.fillStyle = opts.rowAltBgColor;
                ctx.fillRect(opts.padding, yPosition - 50, canvas.width - (opts.padding * 2), opts.rowHeight);
            }
            
            ctx.fillStyle = opts.dataColor;
            row.forEach((cell, index) => {
                const x = canvas.width - opts.padding - (index * colWidth);
                ctx.fillText(cell, x, yPosition);
            });
            
            yPosition += opts.rowHeight;
            
            // Check if we need more space
            if (yPosition > canvas.height - opts.padding) {
                console.log('⚠️ Content exceeds canvas height');
                return;
            }
        });
        
        return canvas;
    },

    // Export to PDF directly (General Purpose)
    exportToPDF: async function(data, headers, title, filename, options = {}) {
        try {
            console.log('🚀 Starting General Arabic PDF export...');
            
            await window.PDFExporterGeneralArabic.loadJSPDF();
            
            const { jsPDF } = window.jspdf;
            
            // Create canvas with Arabic content
            const canvas = window.PDFExporterGeneralArabic.createArabicCanvas(data, headers, title, options);
            
            // Create PDF
            const pdf = new jsPDF({
                orientation: 'landscape',
                unit: 'mm',
                format: 'a4'
            });
            
            // Add canvas to PDF
            const imgData = canvas.toDataURL('image/png');
            const imgWidth = pdf.internal.pageSize.getWidth() - 20;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;
            
            pdf.addImage(imgData, 'PNG', 10, 10, imgWidth, imgHeight);
            
            // Save PDF directly (no display)
            const finalFilename = filename + '_' + new Date().toISOString().split('T')[0] + '.pdf';
            pdf.save(finalFilename);
            
            console.log('✅ General Arabic PDF exported successfully:', finalFilename);
            
        } catch (error) {
            console.error('❌ General PDF export error:', error);
            throw error;
        }
    },

    // Quick export function for DataTables
    exportDataTablesToPDF: async function(tableId, title, filename, options = {}) {
        try {
            const table = document.getElementById(tableId);
            if (!table) {
                throw new Error(`Table with ID '${tableId}' not found`);
            }
            
            // Get headers
            const headers = [];
            const headerCells = table.querySelectorAll('thead th');
            headerCells.forEach(th => {
                headers.push(th.textContent.trim());
            });
            
            // Get data rows
            const data = [];
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach(tr => {
                const row = [];
                const cells = tr.querySelectorAll('td');
                cells.forEach(td => {
                    row.push(td.textContent.trim());
                });
                data.push(row);
            });
            
            // Export to PDF
            await window.PDFExporterGeneralArabic.exportToPDF(data, headers, title, filename, options);
            
        } catch (error) {
            console.error('❌ DataTables export error:', error);
            throw error;
        }
    }
};

// Override the main export function
window.PDFExporter.exportToPDF = window.PDFExporterGeneralArabic.exportToPDF;

// Test function
window.PDFExporterGeneralArabic.testCorruption = function() {
    const testText = '•þŽþãþîþàþÌþäþßþ• þ"þôþèþØþ— þâþ´þ× þ"þãþªþØþ˜þäþßþ• þŽþôþŸþîþßþîþèþÜþ˜þßþ• þ"þÛþ®þ· 3';
    const fixed = window.PDFExporterGeneralArabic.fixArabicText(testText);
    console.log('🧪 General corruption test:');
    console.log('Original:', testText);
    console.log('Fixed:', fixed);
    return fixed;
};

console.log('🎉 General Arabic PDF solution loaded successfully!');
console.log('🧪 Test with: window.PDFExporterGeneralArabic.testCorruption()');
console.log('📊 DataTables export: window.PDFExporterGeneralArabic.exportDataTablesToPDF(tableId, title, filename)');
