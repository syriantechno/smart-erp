# CRM Module Overview

## Scope
The CRM module centralizes all customer-facing information and workflows inside the ERP:

- **Companies**: master data for accounts/organizations.
- **Contacts**: people related to companies.
- **Leads**: pre-sales prospects with status, priority, and expected close dates.
- **Opportunities**: sales deals tied to pipelines & stages.
- **Activities**: timeline of calls/emails/meetings/tasks linked to leads/opportunities.
- **Tasks**: follow-up items that can be assigned to users.
- **Files**: attachments across all CRM entities.

## Key Files
| Area | Controller | Views | Routes |
| ---- | ---------- | ----- | ------ |
| Companies | `app/Http/Controllers/CRM/CompanyController.php` | `resources/views/crm/companies/*` | `/crm/companies`, `/crm/companies/datatable` |
| Contacts | `app/Http/Controllers/CRM/ContactController.php` | `resources/views/crm/contacts/*` | `/crm/contacts`, `/crm/contacts/datatable` |
| Leads | `app/Http/Controllers/CRM/LeadController.php` | `resources/views/crm/leads/*` | `/crm/leads`, `/crm/leads/datatable` |
| Opportunities | `app/Http/Controllers/CRM/OpportunityController.php` | `resources/views/crm/opportunities/*` | `/crm/opportunities`, `/crm/opportunities/datatable` |
| Activities | `app/Http/Controllers/CRM/ActivityController.php` | `resources/views/crm/activities/*` | `/crm/activities`, `/crm/activities/datatable` |
| Tasks | `app/Http/Controllers/CRM/TaskController.php` | `resources/views/crm/tasks/*` | `/crm/tasks`, `/crm/tasks/datatable` |
| Files | `app/Http/Controllers/CRM/FileController.php` | (API/JSON) | `/crm/files/*` |

## UI Patterns
- All tables use the shared Datatable styling with tonal filter buttons.
- Each modal uses the `custom-modal-footer` class with tonal Save/Cancel buttons.
- Pipelines & stages support dynamic filtering on the opportunities view.

## Testing / Seeders
- Run `php artisan migrate` to install CRM tables (already included in schema).
- Seed sample data (optional) via custom factories or manual creation in the UI.
- Ensure storage symbolic link is created (`php artisan storage:link`) for file downloads.

## Next Steps
- Hook CRM notifications into global notification system.
- Implement role-based permissions before production rollout.
- Add integration tests for Datatable endpoints and file uploads.
