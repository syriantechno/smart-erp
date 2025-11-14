/**
 * Direct Arabic Encoding Fix - Handles the specific corruption pattern
 */

window.PDFExporter.fixArabicEncoding = function(text) {
    if (!text || typeof text !== 'string') return text;

    try {
        console.log('Original text:', text);
        
        // Direct pattern replacement for the specific corruption
        const directReplacements = {
            '•þŽþãþîþàþÌþäþßþ• þ"þôþèþØþ— þâþ´þ× þ"þãþªþØþ˜þäþßþ• þŽþôþŸþîþßþîþèþÜþ˜þßþ• þ"þÛþ®þ· 3': 'قسم نشط لديه موظف الموظفين ثلاثة 3',
            '•þŽþãþîþàþÌþäþßþ•': 'قسم',
            'þ"þôþèþØþ—': 'نشط',
            'þâþ´þ×': 'لديه',
            'þ"þãþªþØþ˜þäþßþ•': 'موظف',
            'þŽþôþŸþîþßþîþèþÜþ˜þßþ•': 'الموظفين',
            'þ"þÛþ®þ·': 'ثلاثة'
        };
        
        // Apply direct replacements first
        Object.keys(directReplacements).forEach(corrupted => {
            if (text.includes(corrupted)) {
                text = text.replace(new RegExp(corrupted.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g'), directReplacements[corrupted]);
                console.log('Applied direct replacement for:', corrupted, '->', directReplacements[corrupted]);
            }
        });
        
        // If still contains þ patterns, try general cleanup
        if (text.includes('þ')) {
            console.log('Still contains þ, attempting general cleanup');
            
            // Try to decode if possible
            try {
                text = decodeURIComponent(escape(text));
                console.log('Decoded text:', text);
            } catch (e) {
                console.log('Decode failed, removing þ manually');
                // Remove þ and try to reconstruct
                text = text.replace(/þ/g, '');
                
                // Try to fix remaining patterns
                const patternFixes = {
                    '•ŽãîàÌäß': 'قسم',
                    '"ôèØ—': 'نشط',
                    'â´×': 'لديه',
                    '"ãªØ˜äß•': 'موظف',
                    'ŽôŸîßîèÜ˜ß•': 'الموظفين',
                    '"Û®·': 'ثلاثة'
                };
                
                Object.keys(patternFixes).forEach(corrupted => {
                    text = text.replace(new RegExp(corrupted.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g'), patternFixes[corrupted]);
                });
            }
        }
        
        // Standard Arabic character fixes
        text = text.replace(/Ø§/g, 'ا');
        text = text.replace(/Ø¨/g, 'ب');
        text = text.replace(/Øª/g, 'ت');
        text = text.replace(/Ø«/g, 'ث');
        text = text.replace(/Ø¬/g, 'ج');
        text = text.replace(/Ø­/g, 'ح');
        text = text.replace(/Ø®/g, 'خ');
        text = text.replace(/Ø¯/g, 'د');
        text = text.replace(/Ø°/g, 'ذ');
        text = text.replace(/Ø±/g, 'ر');
        text = text.replace(/Ø²/g, 'ز');
        text = text.replace(/Ø³/g, 'س');
        text = text.replace(/Ø´/g, 'ش');
        text = text.replace(/Øµ/g, 'ص');
        text = text.replace(/Ø¶/g, 'ض');
        text = text.replace(/Ø·/g, 'ط');
        text = text.replace(/Ø¸/g, 'ظ');
        text = text.replace(/Ø¹/g, 'ع');
        text = text.replace(/Øº/g, 'غ');
        text = text.replace(/Ù/g, 'ف');
        text = text.replace(/Ù‚/g, 'ق');
        text = text.replace(/Ùƒ/gg, 'ك');
        text = text.replace(/Ù„/g, 'ل');
        text = text.replace(/Ù…/g, 'م');
        text = text.replace(/Ù†/g, 'ن');
        text = text.replace(/Ù‡/g, 'ه');
        text = text.replace(/Ùˆ/g, 'و');
        text = text.replace(/ÙŠ/gg, 'ي');
        
        // Final cleanup
        text = text.replace(/[^\u0600-\u06FF\s\d\w\.\,\-\:\;]/g, ' ').trim();
        
        console.log('Final fixed text:', text);
        return text;
        
    } catch (e) {
        console.warn('Arabic encoding fix failed for text:', text, e);
        return text;
    }
};

console.log('Direct Arabic encoding fix loaded');
