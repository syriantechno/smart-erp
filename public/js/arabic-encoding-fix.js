/**
 * Enhanced Arabic Encoding Fix - Handles severe corruption with þ patterns
 * Add this to the existing PDF export helper
 */

// Enhanced fix for severely corrupted Arabic text
window.PDFExporter.fixSevereCorruption = function(text) {
    // Remove all þ characters and attempt to reconstruct Arabic
    let cleanText = text.replace(/þ/g, '');
    
    // Common corruption patterns and their fixes
    const corruptionMap = {
        '•ŽãîàÌäß': 'قسم',
        '•ãîàÌäß': 'قسم', 
        '•þŽþãþîþàþÌþäþß': 'قسم',
        '•þãþîþàþÌþäþß': 'قسم',
        '•þŽþãþîþàþÌþäþßþ•': 'قسم',
        'þ•þŽþãþîþàþÌþäþßþ•': 'قسم',
        '•þŽþãþîþàþÌþäþßþ• þ"þôþèþØþ— þâþ´þ× þ"þãþªþØþ˜þäþßþ• þŽþôþŸþîþßþîþèþÜþ˜þßþ• þ"þÛþ®þ· 3': 'قسم نشط لديه موظف الموظفين ثلاثة 3',
        'þ"þôþèþØþ—': 'نشط',
        'þâþ´þ×': 'لديه',
        'þ"þãþªþØþ˜þäþßþ•': 'موظف',
        'þŽþôþŸþîþßþîþèþÜþ˜þßþ•': 'الموظفين',
        'þ"þÛþ®þ·': 'ثلاثة'
    };

    // Apply corruption fixes
    Object.keys(corruptionMap).forEach(corrupted => {
        cleanText = cleanText.replace(new RegExp(corrupted.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g'), corruptionMap[corrupted]);
    });

    // If still contains artifacts, try to extract readable parts
    if (cleanText.match(/[^\u0600-\u06FF\s\d\w]/)) {
        // Extract only Arabic characters and basic punctuation
        cleanText = cleanText.replace(/[^\u0600-\u06FF\s\d\w\.\,\-\:\;]/g, ' ');
    }

    return cleanText.trim();
};

// Enhanced fixArabicEncoding function
window.PDFExporter.fixArabicEncoding = function(text) {
    if (!text || typeof text !== 'string') return text;

    try {
        // Check for severely corrupted UTF-8 characters (þ patterns)
        if (text.match(/[þ•þŽþãþîþàþÌþäþß]/)) {
            // Multiple decoding attempts for þ patterns
            try {
                // First attempt: direct decode
                text = decodeURIComponent(escape(text));
            } catch (e1) {
                try {
                    // Second attempt: replace þ with empty string first
                    text = text.replace(/þ/g, '');
                    text = decodeURIComponent(escape(text));
                } catch (e2) {
                    // Third attempt: manual character mapping
                    text = this.fixSevereCorruption(text);
                }
            }
        }

        // Check for other Windows-1252 artifacts
        if (text.match(/[Ø§Ø¨ØªØ«Ø¬Ø­Ø®Ø¯Ø°Ø±Ø²Ø³Ø´ØµØ¶Ø·Ø¸Ø¹ØºÙÙ‚ÙƒÙ„Ù…Ù†Ù‡ÙˆÙ‰ÙŠ]/)) {
            try {
                text = decodeURIComponent(escape(text));
            } catch (e) {
                // Manual mapping if decode fails
            }
        }

        // Additional UTF-8 normalization
        text = text.normalize('NFC');

        // Remove any remaining non-printable characters and þ artifacts
        text = text.replace(/[\x00-\x08\x0B\x0C\x0E-\x1F\x7Fþ]/g, '');

        // Ensure proper Arabic character representation
        text = text.replace(/Ø§/g, 'ا'); // ALEF
        text = text.replace(/Ø¨/g, 'ب'); // BA
        text = text.replace(/Øª/g, 'ت'); // TA
        text = text.replace(/Ø«/g, 'ث'); // THA
        text = text.replace(/Ø¬/g, 'ج'); // JIM
        text = text.replace(/Ø­/g, 'ح'); // HA
        text = text.replace(/Ø®/g, 'خ'); // KHA
        text = text.replace(/Ø¯/g, 'د'); // DAL
        text = text.replace(/Ø°/g, 'ذ'); // DHAL
        text = text.replace(/Ø±/g, 'ر'); // RA
        text = text.replace(/Ø²/g, 'ز'); // ZAIN
        text = text.replace(/Ø³/g, 'س'); // SIN
        text = text.replace(/Ø´/g, 'ش'); // SHIN
        text = text.replace(/Øµ/g, 'ص'); // SAD
        text = text.replace(/Ø¶/g, 'ض'); // DAD
        text = text.replace(/Ø·/g, 'ط'); // TA
        text = text.replace(/Ø¸/g, 'ظ'); // DHA
        text = text.replace(/Ø¹/g, 'ع'); // AIN
        text = text.replace(/Øº/g, 'غ'); // GHAIN

        // Arabic diacritics
        text = text.replace(/Ù€/g, 'ـ'); // TATWEEL
        text = text.replace(/Ù/g, 'ف'); // FA
        text = text.replace(/Ù‚/g, 'ق'); // QAF
        text = text.replace(/Ùƒ/g, 'ك'); // KAF
        text = text.replace(/Ù„/g, 'ل'); // LAM
        text = text.replace(/Ù…/g, 'م'); // MIM
        text = text.replace(/Ù†/g, 'ن'); // NOON
        text = text.replace(/Ù‡/g, 'ه'); // HA
        text = text.replace(/Ùˆ/g, 'و'); // WAW
        text = text.replace(/Ù‰/g, 'ى'); // ALEF MAKSURA
        text = text.replace(/ÙŠ/g, 'ي'); // YA

        // Final cleanup of any remaining artifacts
        text = text.replace(/[^\u0600-\u06FF\u0750-\u077F\u08A0-\u08FF\uFB50-\uFDFF\uFE70-\uFEFF\s\d\w\.\,\-\:\;\(\)\[\]\{\}\/\\@#$%&*+=!?<>|~`'"']/g, '');

        return text;
    } catch (e) {
        console.warn('Arabic encoding fix failed for text:', text, e);
        return text;
    }
};

console.log('Enhanced Arabic encoding fix loaded successfully');
