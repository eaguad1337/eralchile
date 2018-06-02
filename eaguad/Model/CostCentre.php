<?php namespace EAguad\Model;


class CostCentre extends Model
{
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function reviewers()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function hasReviewer(User $user)
    {
        return $this->reviewers()->where('id', $user->id)->exists();
    }
}
