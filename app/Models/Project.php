<?php

// Temporary alias for backward compatibility
// This file provides an alias to the new location of the Project model

namespace App\Models;

use App\Models\Work\Project as WorkProject;

class Project extends WorkProject
{
    // This class extends the Work\Project model to maintain backward compatibility
    // All functionality is inherited from App\Models\Work\Project
}
