<?php namespace EAguad\Model;


class CostCentre extends Model
{
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviewers()
    {
        return $this->hasMany(User::class, 'reviewer_id');
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
