# System Internal Documentation

ملف توثيق داخلي عام للنظام، نستخدمه لتسجيل حالة الوحدات (Modules)، الإصلاحات المهمة، والملاحظات الداخلية.

---

## HR Departments Management

- **Status**: Completed
- **Date**: 2025-11-15

### Details

- Departments datatable implemented with server-side processing.
- Advanced filtering/search enabled via `filter_field`, `filter_type`, and `filter_value`.
- Manager search fixed to use concatenated first/middle/last name instead of non-existent `full_name` column.
- Create department modal integrated with AJAX submission and automatic code preview.

---

## HR Positions Management

- **Status**: Completed
- **Date**: 2025-11-15

### Details

- Positions datatable implemented with server-side processing.
- Advanced filtering/search enabled via `filter_field`, `filter_type`, and `filter_value` (title, code, department, all).
- Search logic updated in `PositionController@datatable` to correctly filter by title, code, and related department name.
- Create and edit position modals integrated with AJAX, with `is_active` now handled from the backend defaults instead of form checkboxes.

> ملاحظة: يمكن إضافة أقسام أخرى هنا لاحقاً بنفس التنسيق (Recruitment, Payroll, Documents, ...).
