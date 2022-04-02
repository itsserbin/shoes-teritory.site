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
                    <p>Вы можете оплатить заказ банковской картой Visa и MasterCard без комиссии, при этом вы экономите
                        от 50 гривен на покупке. </p>
                    <div class="fs-5 mb-3">Наложеный платеж</div>
                    <p>Вы можете оплатить заказ после его получения в службе доставки «Новая почта». При этом способе
                        оплаты вы оплачиваете сумму складывающуюся из: стоимости доставки (страховка, транспортировка)
                        товара по тарифам «Новой почты» (от 40грн); 2% от стоимости товара.
                    </p>
                    <p><b>Важно!</b> Наложенный платёж возможен только с минимальной предоплатой в связи с Военным
                        положением.</p>
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
                    <h1>Условия возврата и обмена товара</h1>
                    <p>Согласно закону «О защите прав потребителей», нижнее белье и чулочно-носочные изделия включены в
                        «Перечень непродовольственных товаров надлежащего качества», которые не подлежат возврату или
                        обмену
                        на аналогичные модели других размеров, форм, габаритов, фасонов, расцветки или комплектации.</p>

                    <p>Но! Мы всегда лояльны к нашим клиентам, по этому у нас, в отличии от остальных
                        интернет-магазинов,
                        есть обмен купальников, если вам не подойдет размер или цвет, вы без проблем сможете обменять
                        его на
                        другую модель купальника!</p>

                    <p><b>Возврата на категорию нижнего белья нет!</b></p>
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
