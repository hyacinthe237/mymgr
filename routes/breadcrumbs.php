<?php

// // Dashboard
// Breadcrumbs::for('dashboard', function. ($breadcrumbs) {
//     $breadcrumbs->push('Dashboard', route('dashboard'));
// });

// Members
Breadcrumbs::for('members', function ($breadcrumbs) {
    $breadcrumbs = $breadcrumbs->push('Members', route('members.index'));
    return $breadcrumbs;
});

// Members > Member
Breadcrumbs::for('member', function ($breadcrumbs, $member) {
    $breadcrumbs->parent('members');
    $breadcrumbs->push($member->firstname, route('members.show', $member));
});

// TIckets
Breadcrumbs::for('tickets', function ($breadcrumbs) {
    $breadcrumbs->push('Tickets', route('tickets.index'));
});

// Projects > Project > Tickets > Ticket > Edit
Breadcrumbs::for('editTicket', function ($breadcrumbs, $project, $ticket) {
    $breadcrumbs->parent('ticket', $project, $ticket);
    $breadcrumbs->push('Edit', route('tickets.edit', ['code' => $project->code]));
});

// Projects
Breadcrumbs::for('projects', function ($breadcrumbs) {
    $breadcrumbs->push('Projects', route('projects.index'));
});

// Projects > Project
Breadcrumbs::for('project', function ($breadcrumbs, $project) {
    $breadcrumbs->parent('projects');
    $breadcrumbs->push($project->title, route('project.show', ['code' => $project->code]));
});

// Projects > Project > Tickets
Breadcrumbs::for('projectTickets', function ($breadcrumbs, $project) {
    $breadcrumbs->parent('project', $project);
    $breadcrumbs->push('Tickets', route('project.tickets', ['code' => $project->code]));
});

// Projects > Project > Tickets > Ticket
Breadcrumbs::for('ticket', function ($breadcrumbs, $project, $ticket) {
    $breadcrumbs->parent('projectTickets', $project);
    $breadcrumbs->push($ticket->number, route('tickets.show', ['number' => $ticket->number]));
});

// Projects > Project > Tickets > Add
Breadcrumbs::for('addTicket', function ($breadcrumbs, $project) {
    $breadcrumbs->parent('projectTickets', $project);
    $breadcrumbs->push('Add', route('project.tickets.create', $project));
});

// Projects > Project > Stats
Breadcrumbs::for('projectStats', function ($breadcrumbs, $project) {
    $breadcrumbs->parent('project', $project);
    $breadcrumbs->push('Stats', route('project.stats', $project));
});

// Projects > Project > Edit
Breadcrumbs::for('editProject', function ($breadcrumbs, $project) {
    $breadcrumbs->parent('project', $project);
    $breadcrumbs->push('Edit', route('project.edit', $project));
});
