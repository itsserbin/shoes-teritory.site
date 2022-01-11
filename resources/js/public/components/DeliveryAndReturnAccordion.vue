<template>
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button"
                        type="button"
                        @click="showAccordion1Func"
                        :class="{'collapsed' : !showAccordion1,'collaps' : showAccordion1}"

                >
                    Доставка и оплата
                </button>
            </h2>
            <div id="collapseOne"
                 class="accordion-collapse collapse "
                 :class="{'show': showAccordion1 }"
            >
                <div class="accordion-body">
                    <div class="fs-5 mb-3">Банковский перевод на карту</div>
                    <p>Вы можете оплатить заказ банковской картой Visa и
                        MasterCard без комиссии.</p>
                    <div class="fs-5 mb-3">Наложеный платеж</div>
                    <p>Вы можете оплатить заказ после его получения в службе
                        доставки «Новая
                        почта». При этом способе оплаты вы оплачиваете сумму складывающуюся из: стоимости доставки
                        (страховка, транспортировка) товара по тарифам «Новой почты» (от 40грн); 2% от стоимости
                        товара.</p>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button"
                        type="button"
                        @click="showAccordion2Func"
                        :class="{'collapsed' : !showAccordion2,'collaps' : showAccordion2}"
                >
                    Условия возврата и обмена товара
                </button>
            </h2>
            <div id="collapseTwo"
                 class="accordion-collapse collapse"
                 :class="{'show': showAccordion2 }"
            >
                <div class="accordion-body">
                    <p>Возврат возможен в течение 14 дней после получения (для товаров надлежащего качества). Обратная
                        доставка товаров осуществляется за счет покупателя.</p>
                    <p>Согласно действующему законодательству вы можете вернуть товар надлежащего качества или обменять
                        его, если: товар не был в употреблении и не имеет следов использования потребителем: царапин,
                        сколов, потёртостей, пятен и т. п.; товар полностью укомплектован и сохранена фабричная
                        упаковка; сохранены все ярлыки и заводская маркировка; товар сохраняет товарный вид и свои
                        потребительские свойства.
                    </p>
                    <p>Важно: возврата купальников и нижнего белья нет.</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            showAccordion1: false,
            showAccordion2: false,
        }
    },
    methods: {
        showAccordion1Func() {
            this.showAccordion1 = !this.showAccordion1;
        },
        showAccordion2Func() {
            this.showAccordion2 = !this.showAccordion2;
        }
    }
}
</script>
