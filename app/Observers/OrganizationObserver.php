<?php

namespace App\Observers;

use App\Models\Organization;

class OrganizationObserver
{
    /**
     * Handle to the organization "created" event.
     *
     * @param  \App\Organization  $organization
     * @return void
     */
    public function created(Organization $organization)
    {
        $organization->projectCategories()->create(['name' => 'Uncategorized']);
        $organization->ticketCategories()->createMany([
            ['name' => 'To do'], ['name' => 'Doing'], ['name' => 'Done']
        ]);
    }

    /**
     * Handle the organization "updated" event.
     *
     * @param  \App\Organization  $organization
     * @return void
     */
    public function updated(Organization $organization)
    {
        //
    }

    /**
     * Handle the organization "deleted" event.
     *
     * @param  \App\Organization  $organization
     * @return void
     */
    public function deleted(Organization $organization)
    {
        //
    }
}
