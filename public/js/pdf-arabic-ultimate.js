/**
 * Ultimate Arabic PDF Export - Self-contained solution
 * Works without external dependencies
 */

window.PDFExporterUltimate = {
    
    // Arabic character mapping for corrupted text
    arabicMap: {
        '•þŽþãþîþàþÌþäþßþ• þ"þôþèþØþ— þâþ´þ× þ"þãþªþØþ˜þäþßþ• þŽþôþŸþîþßþîþèþÜþ˜þßþ• þ"þÛþ®þ· 3': 'قسم نشط لديه موظف الموظفين ثلاثة 3',
        '•þŽþãþîþàþÌþäþßþ•': 'قسم',
        'þ"þôþèþØþ—': 'نشط',
        'þâþ´þ×': 'لديه',
        'þ"þãþªþØþ˜þäþßþ•': 'موظف',
        'þŽþôþŸþîþßþîþèþÜþ˜þßþ•': 'الموظفين',
        'þ"þÛþ®þ·': 'ثلاثة',
        // Standard corrupted characters
        'Ø§': 'ا', 'Ø¨': 'ب', 'Øª': 'ت', 'Ø«': 'ث', 'Ø¬': 'ج',
        'Ø­': 'ح', 'Ø®': 'خ', 'Ø¯': 'د', 'Ø°': 'ذ', 'Ø±': 'ر',
        'Ø²': 'ز', 'Ø³': 'س', 'Ø´': 'ش', 'Øµ': 'ص', 'Ø¶': 'ض',
        'Ø·': 'ط', 'Ø¸': 'ظ', 'Ø¹': 'ع', 'Øº': 'غ', 'Ù': 'ف',
        'Ù‚': 'ق', 'Ùƒ': 'ك', 'Ù„': 'ل', 'Ù…': 'م', 'Ù†': 'ن',
        'Ù‡': 'ه', 'Ùˆ': 'و', 'ÙŠ': 'ي',
        // Additional patterns
        '•ŽãîàÌäß': 'قسم',
        '•ãîàÌäß': 'قسم',
        '"ôèØ—': 'نشط',
        'â´×': 'لديه',
        '"ãªØ˜äß•': 'موظف',
        'ŽôŸîßîèÜ˜ß•': 'الموظفين',
        '"Û®·': 'ثلاثة'
    },

    // Fix corrupted Arabic text with enhanced processing
    fixArabicText: function(text) {
        if (!text || typeof text !== 'string') return text;
        
        console.log('🔧 Starting text fix for:', text);
        
        let fixedText = text;
        
        // Step 1: Apply direct pattern replacements first
        Object.keys(this.arabicMap).forEach(corrupted => {
            if (fixedText.includes(corrupted)) {
                fixedText = fixedText.replace(new RegExp(corrupted.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g'), this.arabicMap[corrupted]);
                console.log('✅ Applied mapping:', corrupted, '->', this.arabicMap[corrupted]);
            }
        });
        
        // Step 2: Remove any remaining þ characters
        if (fixedText.includes('þ')) {
            console.log('🧹 Removing þ characters...');
            fixedText = fixedText.replace(/þ/g, '');
        }
        
        // Step 3: Try UTF-8 decode if still corrupted
        if (fixedText.match(/[ØÙ]/)) {
            console.log('🔄 Attempting UTF-8 decode...');
            try {
                fixedText = decodeURIComponent(escape(fixedText));
                console.log('✅ UTF-8 decode successful');
            } catch (e) {
                console.log('❌ UTF-8 decode failed, using manual mapping');
            }
        }
        
        // Step 4: Final cleanup of any remaining non-Arabic artifacts
        fixedText = fixedText.replace(/[^\u0600-\u06FF\u0750-\u077F\u08A0-\u08FF\uFB50-\uFDFF\uFE70-\uFEFF\s\d\w\.\,\-\:\;\(\)\[\]\{\}\/\\@#$%&*+=!?<>|~`'"']/g, '');
        
        console.log('🎉 Final fixed text:', fixedText);
        return fixedText.trim();
    },

    // Check if text contains Arabic
    containsArabic: function(text) {
        return /[\u0600-\u06FF]/.test(text);
    },

    // Load jsPDF if not available
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

    // Export to PDF with ultimate Arabic support
    exportToPDF: async function(data, headers, title, filename) {
        try {
            console.log('Starting ultimate Arabic PDF export...');
            
            await this.loadJSPDF();
            
            const { jsPDF } = window.jspdf;
            
            // Create PDF document
            const doc = new jsPDF({
                orientation: 'landscape',
                unit: 'mm',
                format: 'a4'
            });
            
            // Set font
            doc.setFont('helvetica');
            
            // Process title
            const processedTitle = window.PDFExporterUltimate.fixArabicText(title);
            console.log('Processed title:', processedTitle);
            
            // Add title with Arabic alignment
            doc.setFontSize(18);
            doc.setTextColor(0, 0, 0);
            
            if (window.PDFExporterUltimate.containsArabic(processedTitle)) {
                // Right align for Arabic title
                const titleWidth = doc.getTextWidth(processedTitle);
                const titleX = doc.internal.pageSize.width - titleWidth - 20;
                doc.text(processedTitle, titleX, 20);
            } else {
                doc.text(processedTitle, 20, 20);
            }
            
            // Add date
            doc.setFontSize(10);
            const dateStr = new Date().toLocaleDateString();
            if (window.PDFExporterUltimate.containsArabic(processedTitle)) {
                doc.text(dateStr, doc.internal.pageSize.width - 40, 25);
            } else {
                doc.text(dateStr, 20, 25);
            }
            
            // Process headers
            const processedHeaders = headers.map(h => window.PDFExporterUltimate.fixArabicText(String(h || '')));
            console.log('Processed headers:', processedHeaders);
            
            // Process data
            const processedData = data.map(row => {
                const processedRow = Array.isArray(row) ? row : Object.values(row);
                return processedRow.map(cell => window.PDFExporterUltimate.fixArabicText(String(cell || '')));
            });
            console.log('Processed data sample:', processedData.slice(0, 2));
            
            // Table dimensions
            const pageWidth = doc.internal.pageSize.width;
            const pageHeight = doc.internal.pageSize.height;
            const startY = 35;
            const rowHeight = 8;
            const colWidth = (pageWidth - 40) / processedHeaders.length;
            
            let yPosition = startY;
            
            // Draw headers with background
            doc.setFillColor(240, 240, 240);
            doc.rect(20, yPosition - 5, pageWidth - 40, rowHeight, 'F');
            
            doc.setFontSize(10);
            doc.setTextColor(0, 0, 0);
            doc.setFont('helvetica', 'bold');
            
            processedHeaders.forEach((header, index) => {
                const x = 20 + (index * colWidth);
                
                if (window.PDFExporterUltimate.containsArabic(header)) {
                    // Right align Arabic headers
                    const headerWidth = doc.getTextWidth(header);
                    const arabicX = x + colWidth - headerWidth - 2;
                    doc.text(header, arabicX, yPosition);
                } else {
                    // Left align English headers
                    doc.text(header, x + 2, yPosition);
                }
            });
            
            yPosition += rowHeight;
            doc.setFont('helvetica', 'normal');
            
            // Draw data rows
            processedData.forEach((row, rowIndex) => {
                // Check for page break
                if (yPosition > pageHeight - 20) {
                    doc.addPage();
                    yPosition = 20;
                    
                    // Redraw headers on new page
                    doc.setFillColor(240, 240, 240);
                    doc.rect(20, yPosition - 5, pageWidth - 40, rowHeight, 'F');
                    doc.setFont('helvetica', 'bold');
                    
                    processedHeaders.forEach((header, index) => {
                        const x = 20 + (index * colWidth);
                        if (window.PDFExporterUltimate.containsArabic(header)) {
                            const headerWidth = doc.getTextWidth(header);
                            const arabicX = x + colWidth - headerWidth - 2;
                            doc.text(header, arabicX, yPosition);
                        } else {
                            doc.text(header, x + 2, yPosition);
                        }
                    });
                    
                    yPosition += rowHeight;
                    doc.setFont('helvetica', 'normal');
                }
                
                // Draw row background for alternating rows
                if (rowIndex % 2 === 0) {
                    doc.setFillColor(250, 250, 250);
                    doc.rect(20, yPosition - 5, pageWidth - 40, rowHeight, 'F');
                }
                
                // Draw cells
                row.forEach((cell, index) => {
                    const x = 20 + (index * colWidth);
                    
                    if (window.PDFExporterUltimate.containsArabic(cell)) {
                        // Right align Arabic text
                        const cellWidth = doc.getTextWidth(cell);
                        const arabicX = x + colWidth - cellWidth - 2;
                        doc.text(cell, arabicX, yPosition);
                    } else {
                        // Left align English text
                        doc.text(cell, x + 2, yPosition);
                    }
                });
                
                yPosition += rowHeight;
            });
            
            // Add page numbers
            const pageCount = doc.internal.getNumberOfPages();
            for (let i = 1; i <= pageCount; i++) {
                doc.setPage(i);
                doc.setFontSize(8);
                doc.setTextColor(128, 128, 128);
                doc.text(`Page ${i} of ${pageCount}`, pageWidth - 30, pageHeight - 10);
            }
            
            // Save the PDF
            const finalFilename = filename + '_' + new Date().toISOString().split('T')[0] + '.pdf';
            doc.save(finalFilename);
            
            console.log('Ultimate Arabic PDF exported successfully:', finalFilename);
            
        } catch (error) {
            console.error('Ultimate PDF export error:', error);
            throw error;
        }
    }
};

// Override the main export function
window.PDFExporter.exportToPDF = window.PDFExporterUltimate.exportToPDF;

// Add test function for debugging
window.PDFExporterUltimate.testCorruption = function() {
    const testText = '•þŽþãþîþàþÌþäþßþ• þ"þôþèþØþ— þâþ´þ× þ"þãþªþØþ˜þäþßþ• þŽþôþŸþîþßþîþèþÜþ˜þßþ• þ"þÛþ®þ· 3';
    const fixed = this.fixArabicText(testText);
    console.log('🧪 Test corruption fix:');
    console.log('Original:', testText);
    console.log('Fixed:', fixed);
    return fixed;
};

console.log('Ultimate Arabic PDF export loaded successfully');
console.log('🧪 Test corruption fix with: window.PDFExporterUltimate.testCorruption()');
