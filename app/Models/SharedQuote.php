<?php

namespace App\Models;

use App\Models\Share\Share;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $quote_id
 * @property string $type
 * @property string $recipient
 * @property string $created_at
 * @property string $updated_at
 * @property Quote $quote
 */
class SharedQuote extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['quote_id', 'type', 'recipient', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function getShare(): Share
    {
        $classname = 'App\\Models\\Share\\' . ucfirst($this->type);
        return new $classname();
    }

    public function canShare()
    {
        $currentType = $this->getShare();
        foreach ($this->quote->getShareTypes() as $type) {
            if ($type instanceof $currentType) {
                return true;
            }
        }
        return false;
    }
}
