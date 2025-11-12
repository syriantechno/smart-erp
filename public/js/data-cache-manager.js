/**
 * Local Data Management and Synchronization System
 * Data Cache Manager - for loading and managing essential data
 */

class DataCacheManager {
    constructor() {
        this.cache = new Map();
        this.cacheExpiry = 30 * 60 * 1000; // 30 دقيقة
        this.loading = new Set();
        this.apiBase = window.location.origin;
    }

    /**
     * Check if data exists in cache
     */
    has(key) {
        const item = this.cache.get(key);
        if (!item) return false;

        // Check if data has expired
        if (Date.now() - item.timestamp > this.cacheExpiry) {
            this.cache.delete(key);
            return false;
        }

        return true;
    }

    /**
     * Get data from cache
     */
    get(key) {
        if (this.has(key)) {
            return this.cache.get(key).data;
        }
        return null;
    }

    /**
     * Store data in cache
     */
    set(key, data) {
        this.cache.set(key, {
            data: data,
            timestamp: Date.now()
        });
    }

    /**
     * Delete data from cache
     */
    delete(key) {
        this.cache.delete(key);
    }

    /**
     * Clear all data
     */
    clear() {
        this.cache.clear();
        this.loading.clear();
    }

    /**
     * Load data from API with cache
     */
    async load(endpoint, key, force = false) {
        // If data exists and no force reload requested
        if (!force && this.has(key)) {
            console.log(`📦 Using cached data for: ${key}`);
            return this.get(key);
        }

        // If data is already loading
        if (this.loading.has(key)) {
            console.log(`⏳ Data already loading for: ${key}`);
            return null;
        }

        this.loading.add(key);

        try {
            console.log(`🔄 Loading data from API: ${endpoint}`);

            const response = await fetch(`${this.apiBase}${endpoint}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.getCsrfToken()
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }

            const data = await response.json();

            if (data.success !== false) {
                this.set(key, data);
                console.log(`✅ Data loaded and cached: ${key}`, data);
                return data;
            } else {
                throw new Error(data.message || 'API returned error');
            }

        } catch (error) {
            console.error(`❌ Failed to load data for ${key}:`, error);

            // Try to use local data as fallback
            const cachedData = this.get(key);
            if (cachedData) {
                console.log(`📦 Using stale cached data for: ${key}`);
                return cachedData;
            }

            throw error;
        } finally {
            this.loading.delete(key);
        }
    }

    /**
     * Get CSRF token
     */
    getCsrfToken() {
        const token = document.querySelector('meta[name="csrf-token"]');
        return token ? token.getAttribute('content') : '';
    }

    /**
     * Refresh data
     */
    async refresh(key, endpoint) {
        this.delete(key);
        return this.load(endpoint, key, true);
    }

    /**
     * Get cache statistics
     */
    getStats() {
        const stats = {
            totalItems: this.cache.size,
            loadingItems: this.loading.size,
            items: []
        };

        this.cache.forEach((value, key) => {
            stats.items.push({
                key: key,
                age: Date.now() - value.timestamp,
                size: JSON.stringify(value.data).length
            });
        });

        return stats;
    }
}

// Create global instance
const dataCache = new DataCacheManager();

// Helper functions for common use
const preloadCompanies = () => dataCache.load('/hr/employees/companies', 'companies');
const preloadDepartments = (companyId) => dataCache.load(`/hr/departments/api/company/${companyId}`, `departments_${companyId}`);
const preloadEmployees = (departmentId) => dataCache.load(`/hr/employees/positions/department?department_id=${departmentId}`, `employees_${departmentId}`);

// Export for global use
window.DataCacheManager = DataCacheManager;
window.dataCache = dataCache;
window.preloadCompanies = preloadCompanies;
window.preloadDepartments = preloadDepartments;
window.preloadEmployees = preloadEmployees;
