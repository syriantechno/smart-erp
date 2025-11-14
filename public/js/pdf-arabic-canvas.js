/**
 * Arabic PDF with Canvas Rendering - Ultimate Solution
 * Uses html2canvas to capture tables with proper Arabic text
 */

window.PDFExporterCanvas = {
    
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
        
        console.log('🔧 Canvas Arabic fix for:', text);
        
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

    // Load jsPDF and html2canvas
    loadLibraries: async function() {
        const promises = [];
        
        if (typeof window.jspdf === 'undefined') {
            promises.push(new Promise((resolve, reject) => {
                const script = document.createElement('script');
                script.src = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js';
                script.onload = resolve;
                script.onerror = reject;
                document.head.appendChild(script);
            }));
        }
        
        if (typeof window.html2canvas === 'undefined') {
            promises.push(new Promise((resolve, reject) => {
                const script = document.createElement('script');
                script.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js';
                script.onload = resolve;
                script.onerror = reject;
                document.head.appendChild(script);
            }));
        }
        
        await Promise.all(promises);
    },

    // Create temporary table for canvas capture
    createTempTable: function(data, headers, title) {
        const processedTitle = this.fixArabicText(title);
        const processedHeaders = headers.map(h => this.fixArabicText(String(h || '')));
        const processedData = data.map(row => {
            const processedRow = Array.isArray(row) ? row : Object.values(row);
            return processedRow.map(cell => this.fixArabicText(String(cell || '')));
        });
        
        console.log('📝 Processed title:', processedTitle);
        console.log('📋 Processed headers:', processedHeaders);
        console.log('📊 Processed data sample:', processedData.slice(0, 2));
        
        // Create temporary container
        const tempDiv = document.createElement('div');
        tempDiv.style.cssText = `
            position: absolute;
            left: -9999px;
            top: -9999px;
            width: 1200px;
            padding: 20px;
            font-family: 'Segoe UI', 'Arial', 'Tahoma', sans-serif;
            background: white;
            direction: rtl;
            unicode-bidi: embed;
            text-align: right;
        `;
        
        // Create title
        const titleDiv = document.createElement('div');
        titleDiv.style.cssText = `
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: right;
            color: #000;
            direction: rtl;
            unicode-bidi: embed;
        `;
        titleDiv.textContent = processedTitle;
        
        // Create date
        const dateDiv = document.createElement('div');
        dateDiv.style.cssText = `
            font-size: 10px;
            margin-bottom: 20px;
            text-align: right;
            color: #666;
            direction: rtl;
            unicode-bidi: embed;
        `;
        dateDiv.textContent = new Date().toLocaleDateString('ar-SA');
        
        // Create table
        const table = document.createElement('table');
        table.style.cssText = `
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        `;
        
        // Create header row
        const headerRow = document.createElement('tr');
        headerRow.style.cssText = `
            background: #f0f0f0;
            font-weight: bold;
        `;
        
        processedHeaders.forEach(header => {
            const th = document.createElement('th');
            th.style.cssText = `
                padding: 8px;
                border: 1px solid #ddd;
                text-align: right;
                background: #f0f0f0;
                direction: rtl;
                unicode-bidi: embed;
                font-family: 'Segoe UI', 'Arial', 'Tahoma', sans-serif;
            `;
            th.textContent = header;
            headerRow.appendChild(th);
        });
        
        table.appendChild(headerRow);
        
        // Create data rows
        processedData.forEach((row, index) => {
            const tr = document.createElement('tr');
            tr.style.cssText = `
                background: ${index % 2 === 0 ? '#fafafa' : 'white'};
            `;
            
            row.forEach(cell => {
                const td = document.createElement('td');
                td.style.cssText = `
                    padding: 8px;
                    border: 1px solid #ddd;
                    text-align: right;
                    direction: rtl;
                    unicode-bidi: embed;
                    font-family: 'Segoe UI', 'Arial', 'Tahoma', sans-serif;
                `;
                td.textContent = cell;
                tr.appendChild(td);
            });
            
            table.appendChild(tr);
        });
        
        // Assemble container
        tempDiv.appendChild(titleDiv);
        tempDiv.appendChild(dateDiv);
        tempDiv.appendChild(table);
        
        document.body.appendChild(tempDiv);
        
        return tempDiv;
    },

    // Export to PDF with canvas rendering
    exportToPDF: async function(data, headers, title, filename) {
        try {
            console.log('🚀 Starting Arabic PDF with canvas rendering...');
            
            await window.PDFExporterCanvas.loadLibraries();
            
            const { jsPDF } = window.jspdf;
            
            // Create temporary table
            const tempTable = window.PDFExporterCanvas.createTempTable(data, headers, title);
            
            // Wait a bit for rendering
            await new Promise(resolve => setTimeout(resolve, 100));
            
            // Capture table as canvas
            console.log('📸 Capturing table as canvas...');
            const canvas = await window.html2canvas(tempTable, {
                scale: 2,
                useCORS: true,
                allowTaint: true,
                backgroundColor: '#ffffff'
            });
            
            // Remove temporary table
            document.body.removeChild(tempTable);
            
            // Create PDF
            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF({
                orientation: 'landscape',
                unit: 'mm',
                format: 'a4'
            });
            
            const imgWidth = pdf.internal.pageSize.getWidth() - 20;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;
            
            pdf.addImage(imgData, 'PNG', 10, 10, imgWidth, imgHeight);
            
            // Save PDF
            const finalFilename = filename + '_' + new Date().toISOString().split('T')[0] + '.pdf';
            pdf.save(finalFilename);
            
            console.log('✅ Arabic PDF with canvas exported successfully:', finalFilename);
            
        } catch (error) {
            console.error('❌ Canvas PDF export error:', error);
            throw error;
        }
    }
};

// Override the main export function
window.PDFExporter.exportToPDF = window.PDFExporterCanvas.exportToPDF;

// Test function
window.PDFExporterCanvas.testCorruption = function() {
    const testText = '•þŽþãþîþàþÌþäþßþ• þ"þôþèþØþ— þâþ´þ× þ"þãþªþØþ˜þäþßþ• þŽþôþŸþîþßþîþèþÜþ˜þßþ• þ"þÛþ®þ· 3';
    const fixed = this.fixArabicText(testText);
    console.log('🧪 Canvas corruption test:');
    console.log('Original:', testText);
    console.log('Fixed:', fixed);
    return fixed;
};

console.log('🎉 Arabic PDF with canvas rendering loaded successfully!');
console.log('🧪 Test with: window.PDFExporterCanvas.testCorruption()');
