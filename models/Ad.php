<?php

namespace Plugins\Accio\AdsManager\Models;

use Accio\App\Traits\CacheTrait;
use Accio\App\Traits\CollectionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Ad extends Model{
    use CacheTrait, CollectionTrait;

    /**
     * @var string table name
     */
    protected $table = "accio_ads_manager";

    /**
     * @var string primary ID name
     */
    protected $primaryKey = "adID";

    /**
     * @var array
     */
    protected $fillable = ['title', 'slug', 'belongsTo', 'belongsToID', 'displayOn', 'embed', 'postIDs'];

    protected $casts = [
      'postIDs' => 'object'
    ];

    public function generateCache(){
        $data = self::all();
        return $data;
    }

    /**
     * Update cache
     *
     * @param object $itemObj
     * @param string $mode created, updating, updated, deleting, deleted
     *
     * @throws \Exception
     */
    private function updateCache($itemObj, string $mode){

        // Get post data
        switch ($mode) {
            case 'created':
            case 'updated':
            case 'deleted':
                $this->cache("accio_ads_manager", null, false)->refreshState($itemObj, $mode);
                break;
        }
    }
}