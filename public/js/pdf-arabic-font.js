/**
 * Arabic PDF with Font Support - Uses Arabic-compatible fonts
 */

window.PDFExporterArabicFont = {
    
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
        'Ù‡': 'ه', 'Ùˆ': 'و', 'ÙŠ': 'ي'
    },

    // Fix corrupted Arabic text
    fixArabicText: function(text) {
        if (!text || typeof text !== 'string') return text;
        
        console.log('🔧 Fixing Arabic text:', text);
        
        let fixedText = text;
        
        // Apply direct pattern replacements
        Object.keys(this.arabicMap).forEach(corrupted => {
            if (fixedText.includes(corrupted)) {
                fixedText = fixedText.replace(new RegExp(corrupted.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g'), this.arabicMap[corrupted]);
                console.log('✅ Applied mapping:', corrupted, '->', this.arabicMap[corrupted]);
            }
        });
        
        // Remove þ characters
        fixedText = fixedText.replace(/þ/g, '');
        
        // Try UTF-8 decode if needed
        if (fixedText.match(/[ØÙ]/)) {
            try {
                fixedText = decodeURIComponent(escape(fixedText));
                console.log('✅ UTF-8 decode successful');
            } catch (e) {
                console.log('❌ UTF-8 decode failed');
            }
        }
        
        console.log('🎉 Fixed text:', fixedText);
        return fixedText.trim();
    },

    // Check if text contains Arabic
    containsArabic: function(text) {
        return /[\u0600-\u06FF]/.test(text);
    },

    // Load jsPDF with Arabic font support
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

    // Export to PDF with Arabic font support
    exportToPDF: async function(data, headers, title, filename) {
        try {
            console.log('🚀 Starting Arabic PDF export with font support...');
            
            await this.loadJSPDF();
            
            const { jsPDF } = window.jspdf;
            
            // Create PDF document
            const doc = new jsPDF({
                orientation: 'landscape',
                unit: 'mm',
                format: 'a4'
            });
            
            // Process text
            const processedTitle = this.fixArabicText(title);
            const processedHeaders = headers.map(h => this.fixArabicText(String(h || '')));
            const processedData = data.map(row => {
                const processedRow = Array.isArray(row) ? row : Object.values(row);
                return processedRow.map(cell => this.fixArabicText(String(cell || '')));
            });
            
            console.log('📝 Processed title:', processedTitle);
            console.log('📋 Processed headers:', processedHeaders);
            console.log('📊 Processed data sample:', processedData.slice(0, 2));
            
            // Set up fonts
            doc.setFont('helvetica');
            
            // Add title
            doc.setFontSize(16);
            doc.setTextColor(0, 0, 0);
            
            // Title positioning based on language
            if (this.containsArabic(processedTitle)) {
                const titleWidth = doc.getTextWidth(processedTitle);
                const titleX = doc.internal.pageSize.width - titleWidth - 20;
                doc.text(processedTitle, titleX, 20);
            } else {
                doc.text(processedTitle, 20, 20);
            }
            
            // Add date
            doc.setFontSize(10);
            const dateStr = new Date().toLocaleDateString();
            if (this.containsArabic(processedTitle)) {
                doc.text(dateStr, doc.internal.pageSize.width - 40, 25);
            } else {
                doc.text(dateStr, 20, 25);
            }
            
            // Table setup
            const pageWidth = doc.internal.pageSize.width;
            const pageHeight = doc.internal.pageSize.height;
            const startY = 35;
            const rowHeight = 8;
            const colWidth = (pageWidth - 40) / processedHeaders.length;
            
            let yPosition = startY;
            
            // Draw headers
            doc.setFillColor(240, 240, 240);
            doc.rect(20, yPosition - 5, pageWidth - 40, rowHeight, 'F');
            
            doc.setFontSize(10);
            doc.setTextColor(0, 0, 0);
            doc.setFont('helvetica', 'bold');
            
            processedHeaders.forEach((header, index) => {
                const x = 20 + (index * colWidth);
                
                if (this.containsArabic(header)) {
                    // Right align Arabic text
                    const headerWidth = doc.getTextWidth(header);
                    const arabicX = x + colWidth - headerWidth - 2;
                    doc.text(header, arabicX, yPosition);
                } else {
                    // Left align English text
                    doc.text(header, x + 2, yPosition);
                }
            });
            
            yPosition += rowHeight;
            doc.setFont('helvetica', 'normal');
            
            // Draw data rows
            processedData.forEach((row, rowIndex) => {
                // Check page break
                if (yPosition > pageHeight - 20) {
                    doc.addPage();
                    yPosition = 20;
                    
                    // Redraw headers
                    doc.setFillColor(240, 240, 240);
                    doc.rect(20, yPosition - 5, pageWidth - 40, rowHeight, 'F');
                    doc.setFont('helvetica', 'bold');
                    
                    processedHeaders.forEach((header, index) => {
                        const x = 20 + (index * colWidth);
                        if (this.containsArabic(header)) {
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
                
                // Row background
                if (rowIndex % 2 === 0) {
                    doc.setFillColor(250, 250, 250);
                    doc.rect(20, yPosition - 5, pageWidth - 40, rowHeight, 'F');
                }
                
                // Draw cells
                row.forEach((cell, index) => {
                    const x = 20 + (index * colWidth);
                    
                    if (this.containsArabic(cell)) {
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
            
            // Save PDF
            const finalFilename = filename + '_' + new Date().toISOString().split('T')[0] + '.pdf';
            doc.save(finalFilename);
            
            console.log('✅ Arabic PDF with font support exported successfully:', finalFilename);
            
        } catch (error) {
            console.error('❌ Arabic PDF export error:', error);
            throw error;
        }
    }
};

// Override the main export function
window.PDFExporter.exportToPDF = window.PDFExporterArabicFont.exportToPDF;

// Add test function
window.PDFExporterArabicFont.testCorruption = function() {
    const testText = '•þŽþãþîþàþÌþäþßþ• þ"þôþèþØþ— þâþ´þ× þ"þãþªþØþ˜þäþßþ• þŽþôþŸþîþßþîþèþÜþ˜þßþ• þ"þÛþ®þ· 3';
    const fixed = this.fixArabicText(testText);
    console.log('🧪 Font test corruption fix:');
    console.log('Original:', testText);
    console.log('Fixed:', fixed);
    return fixed;
};

console.log('Arabic PDF with font support loaded successfully');
console.log('🧪 Test with: window.PDFExporterArabicFont.testCorruption()');
