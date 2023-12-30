<?php

use App\Models\Project;

/**
 * Method getProjectNameById
 *
 * @param int $project_id
 *
 * @return void
 */
function getProjectNameById(int $project_id = null)
{
    $project = $project_id ? Project::find($project_id) : null;
    return $project ? $project->name : null;
}
