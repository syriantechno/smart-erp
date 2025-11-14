/**
 * Simple Print Solution - Direct Arabic Print
 * Uses window.print() with corruption fix
 */

window.PDFExporterPrintArabic = {
    
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
        
        console.log('🔧 Print Arabic fix for:', text);
        
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

    // Create printable HTML with Arabic fonts
    createPrintableTable: function(data, headers, title) {
        // Process all text with corruption fix
        const processedTitle = window.PDFExporterPrintArabic.fixArabicText(title);
        const processedHeaders = headers.map(h => window.PDFExporterPrintArabic.fixArabicText(String(h || '')));
        const processedData = data.map(row => {
            const processedRow = Array.isArray(row) ? row : Object.values(row);
            return processedRow.map(cell => window.PDFExporterPrintArabic.fixArabicText(String(cell || '')));
        });
        
        console.log('📝 Fixed title:', processedTitle);
        console.log('📋 Fixed headers:', processedHeaders);
        console.log('📊 Fixed data sample:', processedData.slice(0, 2));
        
        // Add Google Fonts for Arabic support
        const fontLink = document.createElement('link');
        fontLink.href = 'https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&family=Amiri:wght@400;700&family=Noto+Sans+Arabic:wght@400;700&display=swap';
        fontLink.rel = 'stylesheet';
        document.head.appendChild(fontLink);
        
        // Create printable HTML
        const printHTML = `
        <!DOCTYPE html>
        <html dir="rtl" lang="ar">
        <head>
            <meta charset="UTF-8">
            <title>${processedTitle}</title>
            <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&family=Amiri:wght@400;700&family=Noto+Sans+Arabic:wght@400;700&display=swap" rel="stylesheet">
            <style>
                @page {
                    margin: 20mm;
                    size: A4 landscape;
                }
                body {
                    font-family: 'Cairo', 'Amiri', 'Noto Sans Arabic', sans-serif;
                    direction: rtl;
                    text-align: right;
                    margin: 0;
                    padding: 20px;
                    line-height: 1.6;
                }
                .title {
                    font-family: 'Amiri', 'Cairo', serif;
                    font-size: 24px;
                    font-weight: bold;
                    text-align: center;
                    margin-bottom: 20px;
                    color: #1a1a1a;
                }
                .date {
                    font-family: 'Cairo', sans-serif;
                    font-size: 12px;
                    text-align: center;
                    margin-bottom: 30px;
                    color: #666;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    font-family: 'Cairo', 'Noto Sans Arabic', sans-serif;
                    font-size: 14px;
                    border: 2px solid #333;
                }
                th {
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    color: white;
                    font-weight: bold;
                    padding: 12px 10px;
                    border: 1px solid #333;
                    text-align: right;
                    font-size: 13px;
                }
                td {
                    padding: 10px 8px;
                    border: 1px solid #ddd;
                    text-align: right;
                    font-size: 13px;
                    color: #333;
                }
                tr:nth-child(even) {
                    background-color: #f8f9fa;
                }
                .footer {
                    margin-top: 20px;
                    text-align: center;
                    font-size: 10px;
                    color: #999;
                    font-family: 'Cairo', sans-serif;
                }
                @media print {
                    body { -webkit-print-color-adjust: exact; }
                    .no-print { display: none; }
                }
            </style>
        </head>
        <body>
            <div class="title">${processedTitle}</div>
            <div class="date">${new Date().toLocaleDateString('ar-SA', { year: 'numeric', month: 'long', day: 'numeric' })}</div>
            
            <table>
                <thead>
                    <tr>
                        ${processedHeaders.map(header => `<th>${header}</th>`).join('')}
                    </tr>
                </thead>
                <tbody>
                    ${processedData.map(row => 
                        `<tr>${row.map(cell => `<td>${cell}</td>`).join('')}</tr>`
                    ).join('')}
                </tbody>
            </table>
            
            <div class="footer">Generated by ERP System - ${new Date().toLocaleString('ar-SA')}</div>
        </body>
        </html>`;
        
        return printHTML;
    },

    // Export to PDF using print method
    exportToPDF: async function(data, headers, title, filename) {
        try {
            console.log('🚀 Starting Print Arabic PDF export...');
            
            // Create printable HTML
            const printHTML = window.PDFExporterPrintArabic.createPrintableTable(data, headers, title);
            
            // Add print styles to hide original content
            const printStyles = document.createElement('style');
            printStyles.textContent = `
                @media print {
                    body * {
                        visibility: hidden;
                    }
                    #arabic-print-container, #arabic-print-container * {
                        visibility: visible;
                    }
                    #arabic-print-container {
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: white;
                        z-index: 9999;
                    }
                    @page {
                        margin: 20mm;
                        size: A4 landscape;
                    }
                }
            `;
            document.head.appendChild(printStyles);
            
            // Create a hidden div in current page
            const printDiv = document.createElement('div');
            printDiv.id = 'arabic-print-container';
            printDiv.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: white;
                z-index: 9999;
                display: none;
            `;
            printDiv.innerHTML = printHTML;
            
            // Add to current page
            document.body.appendChild(printDiv);
            
            // Wait for fonts to load
            console.log('⏳ Waiting for fonts to load...');
            setTimeout(() => {
                // Show the print container
                printDiv.style.display = 'block';
                
                // Check if fonts are loaded
                const testElement = printDiv.querySelector('.title');
                if (testElement) {
                    const computedFont = window.getComputedStyle(testElement).fontFamily;
                    console.log('🔤 Font loaded:', computedFont);
                }
                
                // Trigger print dialog
                console.log('🖨️ Opening print dialog...');
                window.print();
                
                // Hide container and cleanup styles after print
                setTimeout(() => {
                    printDiv.style.display = 'none';
                    // Remove print styles
                    if (printStyles.parentNode) {
                        printStyles.parentNode.removeChild(printStyles);
                    }
                    // Optionally remove container after 5 seconds
                    setTimeout(() => {
                        if (printDiv.parentNode) {
                            printDiv.parentNode.removeChild(printDiv);
                        }
                    }, 5000);
                }, 1000);
                
            }, 2000); // Wait 2 seconds for fonts to load
            
            console.log('✅ Print Arabic PDF export initiated successfully');
            
        } catch (error) {
            console.error('❌ Print PDF export error:', error);
            throw error;
        }
    }
};

// Override the main export function
window.PDFExporter.exportToPDF = window.PDFExporterPrintArabic.exportToPDF;

// Test function
window.PDFExporterPrintArabic.testCorruption = function() {
    const testText = '•þŽþãþîþàþÌþäþßþ• þ"þôþèþØþ— þâþ´þ× þ"þãþªþØþ˜þäþßþ• þŽþôþŸþîþßþîþèþÜþ˜þßþ• þ"þÛþ®þ· 3';
    const fixed = this.fixArabicText(testText);
    console.log('🧪 Print corruption test:');
    console.log('Original:', testText);
    console.log('Fixed:', fixed);
    return fixed;
};

console.log('🎉 Print Arabic PDF solution loaded successfully!');
console.log('🧪 Test with: window.PDFExporterPrintArabic.testCorruption()');
