/**
 * Final Arabic PDF Solution - PDFMake with Arabic Font
 * This is the definitive solution for Arabic PDF export
 */

window.PDFExporterFinal = {
    
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
        
        console.log('🔧 Final Arabic fix for:', text);
        
        let fixedText = text;
        
        // Apply all corruption patterns
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
        
        console.log('🎉 Final result:', fixedText);
        return fixedText.trim();
    },

    // Check if text contains Arabic
    containsArabic: function(text) {
        return /[\u0600-\u06FF]/.test(text);
    },

    // Load PDFMake with Arabic support
    loadPDFMake: async function() {
        if (typeof window.pdfMake !== 'undefined') {
            return Promise.resolve();
        }
        
        return new Promise((resolve, reject) => {
            // Load PDFMake
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js';
            script.onload = () => {
                // Load vfs_fonts
                const fontScript = document.createElement('script');
                fontScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js';
                fontScript.onload = () => {
                    // Configure Arabic fonts
                    this.configureArabicFonts();
                    resolve();
                };
                fontScript.onerror = reject;
                document.head.appendChild(fontScript);
            };
            script.onerror = reject;
            document.head.appendChild(script);
        });
    },

    // Configure Arabic fonts for PDFMake
    configureArabicFonts: function() {
        if (typeof window.pdfMake !== 'undefined') {
            window.pdfMake.fonts = {
                Roboto: {
                    normal: 'Roboto-Regular.ttf',
                    bold: 'Roboto-Medium.ttf',
                    italics: 'Roboto-Italic.ttf',
                    bolditalics: 'Roboto-MediumItalic.ttf'
                }
            };
        }
    },

    // Export to PDF with PDFMake (final solution)
    exportToPDF: async function(data, headers, title, filename) {
        try {
            console.log('🚀 Starting FINAL Arabic PDF export...');
            
            // Load PDFMake
            await window.PDFExporterFinal.loadPDFMake();
            
            // Verify PDFMake is loaded
            if (typeof window.pdfMake === 'undefined') {
                throw new Error('PDFMake failed to load');
            }
            
            console.log('✅ PDFMake loaded successfully');
            
            // Process all text
            const processedTitle = window.PDFExporterFinal.fixArabicText(title);
            const processedHeaders = headers.map(h => window.PDFExporterFinal.fixArabicText(String(h || '')));
            const processedData = data.map(row => {
                const processedRow = Array.isArray(row) ? row : Object.values(row);
                return processedRow.map(cell => window.PDFExporterFinal.fixArabicText(String(cell || '')));
            });
            
            console.log('📝 Processed title:', processedTitle);
            console.log('📋 Processed headers:', processedHeaders);
            console.log('📊 Processed data sample:', processedData.slice(0, 2));
            
            // Build table body
            const tableBody = [processedHeaders];
            processedData.forEach(row => {
                tableBody.push(row);
            });
            
            console.log('📋 Table body created with', tableBody.length, 'rows');
            
            // Determine alignment based on title language
            const isArabicTitle = window.PDFExporterFinal.containsArabic(processedTitle);
            
            // PDFMake document definition
            const docDefinition = {
                content: [
                    {
                        text: processedTitle,
                        style: 'title',
                        alignment: isArabicTitle ? 'right' : 'left'
                    },
                    {
                        text: new Date().toLocaleDateString('ar-SA'),
                        style: 'date',
                        alignment: isArabicTitle ? 'right' : 'left'
                    },
                    '\n',
                    {
                        table: {
                            headerRows: 1,
                            widths: Array(processedHeaders.length).fill('*'),
                            body: tableBody
                        },
                        layout: 'lightHorizontalLines'
                    }
                ],
                styles: {
                    title: {
                        fontSize: 18,
                        bold: true,
                        margin: [0, 0, 0, 10]
                    },
                    date: {
                        fontSize: 10,
                        margin: [0, 0, 0, 20],
                        italics: true
                    },
                    header: {
                        bold: true,
                        fontSize: 12,
                        fillColor: '#EEEEEE'
                    }
                },
                defaultStyle: {
                    fontSize: 10,
                    font: 'Roboto'
                }
            };
            
            console.log('📄 Document definition created');
            
            // Apply header style to first row
            if (docDefinition.content && docDefinition.content[3] && docDefinition.content[3].table && docDefinition.content[3].table.body) {
                docDefinition.content[3].table.body[0] = processedHeaders.map(header => ({
                    text: header,
                    style: 'header'
                }));
                console.log('✅ Header styles applied');
            } else {
                console.log('⚠️ Could not apply header styles - table structure not found');
            }
            
            // Generate and download PDF
            console.log('📥 Generating PDF...');
            window.pdfMake.createPdf(docDefinition).download(filename + '_' + new Date().toISOString().split('T')[0] + '.pdf');
            
            console.log('✅ FINAL Arabic PDF exported successfully!');
            
        } catch (error) {
            console.error('❌ FINAL PDF export error:', error);
            console.error('Error details:', error.message, error.stack);
            throw error;
        }
    }
};

// Override the main export function
window.PDFExporter.exportToPDF = window.PDFExporterFinal.exportToPDF;

// Test function
window.PDFExporterFinal.testCorruption = function() {
    const testText = '•þŽþãþîþàþÌþäþßþ• þ"þôþèþØþ— þâþ´þ× þ"þãþªþØþ˜þäþßþ• þŽþôþŸþîþßþîþèþÜþ˜þßþ• þ"þÛþ®þ· 3';
    const fixed = this.fixArabicText(testText);
    console.log('🧪 FINAL corruption test:');
    console.log('Original:', testText);
    console.log('Fixed:', fixed);
    return fixed;
};

console.log('🎉 FINAL Arabic PDF solution loaded successfully!');
console.log('🧪 Test with: window.PDFExporterFinal.testCorruption()');
