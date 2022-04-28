<?php

namespace App\Repositories;

use App\Models\Enum\OptionsName;
use App\Models\Options as Model;

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
        $options[OptionsName::OPTION_SCHEDULE] = $this->getOptionValue(OptionsName::OPTION_SCHEDULE);
        $options[OptionsName::OPTION_EMAIL] = $this->getOptionValue(OptionsName::OPTION_EMAIL);
        $options[OptionsName::OPTION_PHONE] = $this->getOptionValue(OptionsName::OPTION_PHONE);
        $options[OptionsName::OPTION_FACEBOOK] = $this->getOptionValue(OptionsName::OPTION_FACEBOOK);
        $options[OptionsName::OPTION_INSTAGRAM] = $this->getOptionValue(OptionsName::OPTION_INSTAGRAM);
        $options[OptionsName::OPTION_TELEGRAM] = $this->getOptionValue(OptionsName::OPTION_TELEGRAM);
        $options[OptionsName::OPTION_VIBER] = $this->getOptionValue(OptionsName::OPTION_VIBER);
        $options[OptionsName::OPTION_WHATSAPP] = $this->getOptionValue(OptionsName::OPTION_WHATSAPP);
        $options[OptionsName::OPTION_FB_MESSENGER] = $this->getOptionValue(OptionsName::OPTION_FB_MESSENGER);
        $options[OptionsName::OPTION_BRAND] = $this->getOptionValue(OptionsName::OPTION_BRAND);
        $options[OptionsName::OPTION_META_TITLE_UA] = $this->getOptionValue(OptionsName::OPTION_META_TITLE_UA);
        $options[OptionsName::OPTION_META_DESCRIPTION_UA] = $this->getOptionValue(OptionsName::OPTION_META_DESCRIPTION_UA);
        $options[OptionsName::OPTION_META_TITLE_RU] = $this->getOptionValue(OptionsName::OPTION_META_TITLE_RU);
        $options[OptionsName::OPTION_META_DESCRIPTION_RU] = $this->getOptionValue(OptionsName::OPTION_META_DESCRIPTION_RU);
        $options[OptionsName::OPTION_TEXT_DELIVERY_AND_PAYMENT_UA] = $this->getOptionValue(OptionsName::OPTION_TEXT_DELIVERY_AND_PAYMENT_UA);
        $options[OptionsName::OPTION_TEXT_RETURN_AND_EXCHANGE_UA] = $this->getOptionValue(OptionsName::OPTION_TEXT_RETURN_AND_EXCHANGE_UA);
        $options[OptionsName::OPTION_TEXT_DELIVERY_AND_PAYMENT_RU] = $this->getOptionValue(OptionsName::OPTION_TEXT_DELIVERY_AND_PAYMENT_RU);
        $options[OptionsName::OPTION_TEXT_RETURN_AND_EXCHANGE_RU] = $this->getOptionValue(OptionsName::OPTION_TEXT_RETURN_AND_EXCHANGE_RU);

        return $options;
    }

    /**
     * @param $data
     * @return bool
     */
    public function updateMainOptions($data): bool
    {
        if ($this->getOptionValue(OptionsName::OPTION_SCHEDULE)) {
            $this->update(OptionsName::OPTION_SCHEDULE, $data[OptionsName::OPTION_SCHEDULE]);
        } else {
            $this->create(OptionsName::OPTION_SCHEDULE, $data[OptionsName::OPTION_SCHEDULE]);
        }

        if ($this->getOptionValue(OptionsName::OPTION_EMAIL)) {
            $this->update(OptionsName::OPTION_EMAIL, $data[OptionsName::OPTION_EMAIL]);
        } else {
            $this->create(OptionsName::OPTION_EMAIL, $data[OptionsName::OPTION_EMAIL]);
        }

        if ($this->getOptionValue(OptionsName::OPTION_PHONE)) {
            $this->update(OptionsName::OPTION_PHONE, $data[OptionsName::OPTION_PHONE]);
        } else {
            $this->create(OptionsName::OPTION_PHONE, $data[OptionsName::OPTION_PHONE]);
        }

        if ($this->getOptionValue(OptionsName::OPTION_FACEBOOK)) {
            $this->update(OptionsName::OPTION_FACEBOOK, $data[OptionsName::OPTION_FACEBOOK]);
        } else {
            $this->create(OptionsName::OPTION_FACEBOOK, $data[OptionsName::OPTION_FACEBOOK]);
        }

        if ($this->getOptionValue(OptionsName::OPTION_INSTAGRAM)) {
            $this->update(OptionsName::OPTION_INSTAGRAM, $data[OptionsName::OPTION_INSTAGRAM]);
        } else {
            $this->create(OptionsName::OPTION_INSTAGRAM, $data[OptionsName::OPTION_INSTAGRAM]);
        }

        if ($this->getOptionValue(OptionsName::OPTION_TELEGRAM)) {
            $this->update(OptionsName::OPTION_TELEGRAM, $data[OptionsName::OPTION_TELEGRAM]);
        } else {
            $this->create(OptionsName::OPTION_TELEGRAM, $data[OptionsName::OPTION_TELEGRAM]);
        }

        if ($this->getOptionValue(OptionsName::OPTION_VIBER)) {
            $this->update(OptionsName::OPTION_VIBER, $data[OptionsName::OPTION_VIBER]);
        } else {
            $this->create(OptionsName::OPTION_VIBER, $data[OptionsName::OPTION_VIBER]);
        }

        if ($this->getOptionValue(OptionsName::OPTION_WHATSAPP)) {
            $this->update(OptionsName::OPTION_WHATSAPP, $data[OptionsName::OPTION_WHATSAPP]);
        } else {
            $this->create(OptionsName::OPTION_WHATSAPP, $data[OptionsName::OPTION_WHATSAPP]);
        }

        if ($this->getOptionValue(OptionsName::OPTION_FB_MESSENGER)) {
            $this->update(OptionsName::OPTION_FB_MESSENGER, $data[OptionsName::OPTION_FB_MESSENGER]);
        } else {
            $this->create(OptionsName::OPTION_FB_MESSENGER, $data[OptionsName::OPTION_FB_MESSENGER]);
        }

        if ($this->getOptionValue(OptionsName::OPTION_BRAND)) {
            $this->update(OptionsName::OPTION_BRAND, $data[OptionsName::OPTION_BRAND]);
        } else {
            $this->create(OptionsName::OPTION_BRAND, $data[OptionsName::OPTION_BRAND]);
        }

        if ($this->getOptionValue(OptionsName::OPTION_META_TITLE_UA)) {
            $this->update(OptionsName::OPTION_META_TITLE_UA, $data[OptionsName::OPTION_META_TITLE_UA]);
        } else {
            $this->create(OptionsName::OPTION_META_TITLE_UA, $data[OptionsName::OPTION_META_TITLE_UA]);
        }

        if ($this->getOptionValue(OptionsName::OPTION_META_DESCRIPTION_UA)) {
            $this->update(OptionsName::OPTION_META_DESCRIPTION_UA, $data[OptionsName::OPTION_META_DESCRIPTION_UA]);
        } else {
            $this->create(OptionsName::OPTION_META_DESCRIPTION_UA, $data[OptionsName::OPTION_META_DESCRIPTION_UA]);
        }

        if ($this->getOptionValue(OptionsName::OPTION_META_TITLE_RU)) {
            $this->update(OptionsName::OPTION_META_TITLE_RU, $data[OptionsName::OPTION_META_TITLE_RU]);
        } else {
            $this->create(OptionsName::OPTION_META_TITLE_RU, $data[OptionsName::OPTION_META_TITLE_RU]);
        }

        if ($this->getOptionValue(OptionsName::OPTION_META_DESCRIPTION_RU)) {
            $this->update(OptionsName::OPTION_META_DESCRIPTION_RU, $data[OptionsName::OPTION_META_DESCRIPTION_RU]);
        } else {
            $this->create(OptionsName::OPTION_META_DESCRIPTION_RU, $data[OptionsName::OPTION_META_DESCRIPTION_RU]);
        }

        if ($this->getOptionValue(OptionsName::OPTION_TEXT_RETURN_AND_EXCHANGE_UA)) {
            $this->update(OptionsName::OPTION_TEXT_RETURN_AND_EXCHANGE_UA, $data[OptionsName::OPTION_TEXT_RETURN_AND_EXCHANGE_UA]);
        } else {
            $this->create(OptionsName::OPTION_TEXT_RETURN_AND_EXCHANGE_UA, $data[OptionsName::OPTION_TEXT_RETURN_AND_EXCHANGE_UA]);
        }

        if ($this->getOptionValue(OptionsName::OPTION_TEXT_DELIVERY_AND_PAYMENT_UA)) {
            $this->update(OptionsName::OPTION_TEXT_DELIVERY_AND_PAYMENT_UA, $data[OptionsName::OPTION_TEXT_DELIVERY_AND_PAYMENT_UA]);
        } else {
            $this->create(OptionsName::OPTION_TEXT_DELIVERY_AND_PAYMENT_UA, $data[OptionsName::OPTION_TEXT_DELIVERY_AND_PAYMENT_UA]);
        }

        if ($this->getOptionValue(OptionsName::OPTION_TEXT_RETURN_AND_EXCHANGE_RU)) {
            $this->update(OptionsName::OPTION_TEXT_RETURN_AND_EXCHANGE_RU, $data[OptionsName::OPTION_TEXT_RETURN_AND_EXCHANGE_RU]);
        } else {
            $this->create(OptionsName::OPTION_TEXT_RETURN_AND_EXCHANGE_RU, $data[OptionsName::OPTION_TEXT_RETURN_AND_EXCHANGE_RU]);
        }

        if ($this->getOptionValue(OptionsName::OPTION_TEXT_DELIVERY_AND_PAYMENT_RU)) {
            $this->update(OptionsName::OPTION_TEXT_DELIVERY_AND_PAYMENT_RU, $data[OptionsName::OPTION_TEXT_DELIVERY_AND_PAYMENT_RU]);
        } else {
            $this->create(OptionsName::OPTION_TEXT_DELIVERY_AND_PAYMENT_RU, $data[OptionsName::OPTION_TEXT_DELIVERY_AND_PAYMENT_RU]);
        }

        return true;
    }

    /**
     * @return array
     */
    public function getScriptsOptions(): array
    {
        $options['head_scripts'] = $this->getOptionValue(OptionsName::OPTION_HEAD_SCRIPTS);
        $options['after_body_scripts'] = $this->getOptionValue(OptionsName::OPTION_AFTER_BODY_SCRIPTS);
        $options['footer_scripts'] = $this->getOptionValue(OptionsName::OPTION_FOOTER_SCRIPTS);

        return $options;
    }

    /**
     * @param $data
     * @return bool
     */
    public function updateScriptsOptions($data): bool
    {
        if ($this->getOptionValue(OptionsName::OPTION_HEAD_SCRIPTS)) {
            $this->update(OptionsName::OPTION_HEAD_SCRIPTS, $data['head_scripts']);
        } else {
            $this->create(OptionsName::OPTION_HEAD_SCRIPTS, $data['head_scripts']);
        }

        if ($this->getOptionValue(OptionsName::OPTION_AFTER_BODY_SCRIPTS)) {
            $this->update(OptionsName::OPTION_AFTER_BODY_SCRIPTS, $data['after_body_scripts']);
        } else {
            $this->create(OptionsName::OPTION_AFTER_BODY_SCRIPTS, $data['after_body_scripts']);
        }

        if ($this->getOptionValue(OptionsName::OPTION_FOOTER_SCRIPTS)) {
            $this->update(OptionsName::OPTION_FOOTER_SCRIPTS, $data['footer_scripts']);
        } else {
            $this->create(OptionsName::OPTION_FOOTER_SCRIPTS, $data['footer_scripts']);
        }

        return true;
    }

    public function getOptionValue($name)
    {
        return $this->model::where('name', $name)->select('value')->first();
    }

    public function create($name, $value)
    {
        return $this->model::create(['name' => $name, 'value' => $value]);
    }

    public function update($name, $value)
    {
        return $this->model::where('name', $name)->update(['value' => $value]);
    }
}
