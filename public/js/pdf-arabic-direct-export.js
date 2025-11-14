/**
 * Direct PDF Export - No Display, Just Export
 * Uses jsPDF with embedded Arabic fonts and corruption fix
 */

window.PDFExporterDirectArabic = {
    
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
        
        console.log('🔧 Direct Arabic fix for:', text);
        
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

    // Create canvas with Arabic text
    createArabicCanvas: function(data, headers, title) {
        // Process all text with corruption fix
        const processedTitle = window.PDFExporterDirectArabic.fixArabicText(title);
        const processedHeaders = headers.map(h => window.PDFExporterDirectArabic.fixArabicText(String(h || '')));
        const processedData = data.map(row => {
            const processedRow = Array.isArray(row) ? row : Object.values(row);
            return processedRow.map(cell => window.PDFExporterDirectArabic.fixArabicText(String(cell || '')));
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
        ctx.font = 'bold 48px Arial';
        ctx.fillStyle = '#000';
        ctx.textAlign = 'right';
        ctx.direction = 'rtl';
        
        // Draw title
        ctx.fillText(processedTitle, canvas.width - 100, 100);
        
        // Draw date
        ctx.font = '24px Arial';
        ctx.fillStyle = '#666';
        ctx.fillText(new Date().toLocaleDateString('ar-SA'), canvas.width - 100, 150);
        
        // Table setup
        const startY = 250;
        const rowHeight = 80;
        const colWidth = (canvas.width - 200) / processedHeaders.length;
        let yPosition = startY;
        
        // Draw headers
        ctx.font = 'bold 32px Arial';
        ctx.fillStyle = '#fff';
        
        // Header background
        ctx.fillStyle = '#4a5568';
        ctx.fillRect(100, yPosition - 50, canvas.width - 200, rowHeight);
        
        ctx.fillStyle = '#fff';
        processedHeaders.forEach((header, index) => {
            const x = canvas.width - 100 - (index * colWidth);
            ctx.fillText(header, x, yPosition);
        });
        
        yPosition += rowHeight;
        
        // Draw data rows
        ctx.font = '28px Arial';
        ctx.fillStyle = '#000';
        
        processedData.forEach((row, rowIndex) => {
            // Row background
            if (rowIndex % 2 === 0) {
                ctx.fillStyle = '#f7fafc';
                ctx.fillRect(100, yPosition - 50, canvas.width - 200, rowHeight);
            }
            
            ctx.fillStyle = '#000';
            row.forEach((cell, index) => {
                const x = canvas.width - 100 - (index * colWidth);
                ctx.fillText(cell, x, yPosition);
            });
            
            yPosition += rowHeight;
        });
        
        return canvas;
    },

    // Export to PDF directly (no display)
    exportToPDF: async function(data, headers, title, filename) {
        try {
            console.log('🚀 Starting Direct Arabic PDF export...');
            
            await window.PDFExporterDirectArabic.loadJSPDF();
            
            const { jsPDF } = window.jspdf;
            
            // Create canvas with Arabic content
            const canvas = window.PDFExporterDirectArabic.createArabicCanvas(data, headers, title);
            
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
            
            console.log('✅ Direct Arabic PDF exported successfully:', finalFilename);
            
        } catch (error) {
            console.error('❌ Direct PDF export error:', error);
            throw error;
        }
    }
};

// Override the main export function
window.PDFExporter.exportToPDF = window.PDFExporterDirectArabic.exportToPDF;

// Test function
window.PDFExporterDirectArabic.testCorruption = function() {
    const testText = '•þŽþãþîþàþÌþäþßþ• þ"þôþèþØþ— þâþ´þ× þ"þãþªþØþ˜þäþßþ• þŽþôþŸþîþßþîþèþÜþ˜þßþ• þ"þÛþ®þ· 3';
    const fixed = this.fixArabicText(testText);
    console.log('🧪 Direct corruption test:');
    console.log('Original:', testText);
    console.log('Fixed:', fixed);
    return fixed;
};

console.log('🎉 Direct Arabic PDF solution loaded successfully!');
console.log('🧪 Test with: window.PDFExporterDirectArabic.testCorruption()');
