<?php

namespace App\Repositories;

use App\Models\Options;
use App\Models\Options as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use PhpParser\Node\Expr\AssignOp\Concat;

/**
 * Class ArticleRepository
 *
 * @package App\Repositories
 */
class OptionsRepository extends CoreRepository
{
    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * @return array
     */
    public function getToProd(): array
    {
        return $this->getMainOptions() + $this->getScriptsOptions();
    }

    /**
     * @return array
     */
    public function getMainOptions(): array
    {
        $options['schedule'] = $this->getSchedule();
        $options['email'] = $this->getEmail();
        $options['phone'] = $this->getPhone();
        $options['facebook'] = $this->getFacebook();
        $options['instagram'] = $this->getInstagram();
        $options['telegram'] = $this->getTelegram();
        $options['viber'] = $this->getViber();
        $options['whatsapp'] = $this->getWhatsapp();
        $options['fb_messenger'] = $this->getFbMessenger();

        return $options;
    }

    /**
     * @param $data
     * @return bool
     */
    public function updateMainOptions($data): bool
    {
        if ($this->getSchedule()) {
            $this->model::where('name', 'schedule')->update(['value' => $data['schedule']]);
        } else {
            $this->model::create(['name', 'schedule', 'value' => $data['schedule']]);
        }

        if ($this->getEmail()) {
            $this->model::where('name', 'email')->update(['value' => $data['email']]);
        } else {
            $this->model::create(['name', 'email', 'value' => $data['email']]);
        }

        if ($this->getPhone()) {
            $this->model::where('name', 'phone')->update(['value' => $data['phone']]);
        } else {
            $this->model::create(['name', 'phone', 'value' => $data['phone']]);
        }

        if ($this->getFacebook()) {
            $this->model::where('name', 'facebook')->update(['value' => $data['facebook']]);
        } else {
            $this->model::create(['name', 'facebook', 'value' => $data['facebook']]);
        }

        if ($this->getInstagram()) {
            $this->model::where('name', 'instagram')->update(['value' => $data['instagram']]);
        } else {
            $this->model::create(['name', 'instagram', 'value' => $data['instagram']]);
        }

        if ($this->getTelegram()) {
            $this->model::where('name', 'telegram')->update(['value' => $data['telegram']]);
        } else {
            $this->model::create(['name', 'telegram', 'value' => $data['telegram']]);
        }

        if ($this->getViber()) {
            $this->model::where('name', 'viber')->update(['value' => $data['viber']]);
        } else {
            $this->model::create(['name', 'viber', 'value' => $data['viber']]);
        }

        if ($this->getWhatsapp()) {
            $this->model::where('name', 'whatsapp')->update(['value' => $data['whatsapp']]);
        } else {
            $this->model::create(['name', 'whatsapp', 'value' => $data['whatsapp']]);
        }

        if ($this->getFbMessenger()) {
            $this->model::where('name', 'fb_messenger')->update(['value' => $data['fb_messenger']]);
        } else {
            $this->model::create(['name', 'fb_messenger', 'value' => $data['fb_messenger']]);
        }

        return true;
    }

    /**
     * @return array
     */
    public function getScriptsOptions(): array
    {
        $options['head_scripts'] = $this->getHeadScripts();
        $options['after_body_scripts'] = $this->getAfterBodyScripts();
        $options['footer_scripts'] = $this->getFooterScripts();

        return $options;
    }

    /**
     * @param $data
     * @return bool
     */
    public function updateScriptsOptions($data): bool
    {
        if ($this->getHeadScripts()) {
            $this->model::where('name', 'head_scripts')->update(['value' => $data['head_scripts']]);
        } else {
            $this->model::create(['name' => 'head_scripts', 'value' => $data['head_scripts']]);
        }

        if ($this->getAfterBodyScripts()) {
            $this->model::where('name', 'after_body_scripts')->update(['value' => $data['after_body_scripts']]);
        } else {
            $this->model::create(['name' => 'after_body_scripts', 'value' => $data['after_body_scripts']]);
        }

        if ($this->getFooterScripts()) {
            $this->model::where('name', 'footer_scripts')->update(['value' => $data['footer_scripts']]);
        } else {
            $this->model::create(['name' => 'footer_scripts', 'value' => $data['footer_scripts']]);
        }

        return true;
    }

    public function getSchedule()
    {
        return $this->model::where('name', 'schedule')->select('value')->first();
    }

    public function getEmail()
    {
        return $this->model::where('name', 'email')->select('value')->first();
    }

    public function getPhone()
    {
        return $this->model::where('name', 'phone')->select('value')->first();
    }

    public function getFacebook()
    {
        return $this->model::where('name', 'facebook')->select('value')->first();
    }

    public function getInstagram()
    {
        return $this->model::where('name', 'instagram')->select('value')->first();
    }

    public function getTelegram()
    {
        return $this->model::where('name', 'telegram')->select('value')->first();
    }

    public function getViber()
    {
        return $this->model::where('name', 'viber')->select('value')->first();
    }

    public function getWhatsapp()
    {
        return $this->model::where('name', 'whatsapp')->select('value')->first();
    }

    public function getFbMessenger()
    {
        return $this->model::where('name', 'fb_messenger')->select('value')->first();
    }

    public function getHeadScripts()
    {
        return $this->model::where('name', 'head_scripts')->select('value')->first();
    }

    public function getAfterBodyScripts()
    {
        return $this->model::where('name', 'after_body_scripts')->select('value')->first();
    }

    public function getFooterScripts()
    {
        return $this->model::where('name', 'footer_scripts')->select('value')->first();
    }
}
