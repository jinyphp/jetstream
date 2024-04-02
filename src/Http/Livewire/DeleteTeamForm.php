<?php

namespace Jiny\Jetstream\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Jiny\Jetstream\Actions\ValidateTeamDeletion;
use Jiny\Jetstream\Contracts\DeletesTeams;
use Jiny\Jetstream\RedirectsActions;
use Livewire\Component;

class DeleteTeamForm extends Component
{
    use RedirectsActions;

    /**
     * The team instance.
     *
     * @var mixed
     */
    public $team;

    /**
     * Indicates if team deletion is being confirmed.
     *
     * @var bool
     */
    public $confirmingTeamDeletion = false;

    /**
     * Mount the component.
     *
     * @param  mixed  $team
     * @return void
     */
    public function mount($team)
    {
        $this->team = $team;
    }

    /**
     * Delete the team.
     *
     * @param  \Jiny\Jetstream\Actions\ValidateTeamDeletion  $validator
     * @param  \Jiny\Jetstream\Contracts\DeletesTeams  $deleter
     * @return mixed
     */
    public function deleteTeam(ValidateTeamDeletion $validator, DeletesTeams $deleter)
    {
        $validator->validate(Auth::user(), $this->team);

        $deleter->delete($this->team);

        $this->team = null;

        return $this->redirectPath($deleter);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('teams.delete-team-form');
    }
}
