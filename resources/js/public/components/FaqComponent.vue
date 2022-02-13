<template>
   <div class="container">
       <div class="row justify-content-center mb-3">
           <div class="col-12 col-md-6">
               <div class="block-title mb-3">Ответы на часто-задаваемые вопросы</div>
               <div class="accordion" id="accordionExample">
                   <div class="accordion-item">
                       <h2 class="accordion-header" id="headingOne">
                           <button class="accordion-button"
                                   type="button"
                                   @click="showAccordion1Func"
                                   :class="{'collapsed' : !showAccordion1,'collaps' : showAccordion1}"

                           >
                               Как оформить заказ?
                           </button>
                       </h2>
                       <div id="collapseOne"
                            class="accordion-collapse collapse "
                            :class="{'show': showAccordion1 }"
                       >
                           <div class="accordion-body">
                               <p>Для оформления заказа вам нужно выбрать понравившиеся товары и положить их в корзину.</p>
                               <p>В корзине проверить все выбранные товары, цены и общую сумму покупки.</p>
                               <p>Далее достаточно ввести данные для доставки и номер контактного телефона для связи с вами.</p>
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
                               Как часто вы делаете отправку товара?
                           </button>
                       </h2>
                       <div id="collapseTwo"
                            class="accordion-collapse collapse"
                            :class="{'show': showAccordion2 }"
                       >
                           <div class="accordion-body">
                               <p>Отправка товара осуществляется каждый день в 13-00 без выходных.</p>
                           </div>
                       </div>
                   </div>
                   <div class="accordion-item">
                       <h2 class="accordion-header">
                           <button class="accordion-button"
                                   type="button"
                                   @click="showAccordion3Func"
                                   :class="{'collapsed' : !showAccordion3,'collaps' : showAccordion3}"
                           >
                               С какого города отправляете товар?
                           </button>
                       </h2>
                       <div class="accordion-collapse collapse"
                            :class="{'show': showAccordion3 }"
                       >
                           <div class="accordion-body">
                               <p>Наш склад находится в Харькове
                               </p>
                           </div>
                       </div>
                   </div>

                   <div class="accordion-item">
                       <h2 class="accordion-header">
                           <button class="accordion-button"
                                   type="button"
                                   @click="showAccordion4Func"
                                   :class="{'collapsed' : !showAccordion4,'collaps' : showAccordion4}"
                           >
                               У вас есть офлайн магазин? Хочу прийти и померять перед покупкой.
                           </button>
                       </h2>
                       <div class="accordion-collapse collapse"
                            :class="{'show': showAccordion4 }"
                       >
                           <div class="accordion-body">
                               <p>Наши магазины пока есть только онлайн. Но примерить одежду перед покупкой можно на почте, также
                                   дома. У нас есть обмен в течении 14 дней после покупки товара.
                               </p>
                           </div>
                       </div>
                   </div>

                   <div class="accordion-item">
                       <h2 class="accordion-header">
                           <button class="accordion-button"
                                   type="button"
                                   @click="showAccordion5Func"
                                   :class="{'collapsed' : !showAccordion5,'collaps' : showAccordion5}"
                           >
                               Возможно ли сделать распаровку комплекта?
                           </button>
                       </h2>
                       <div class="accordion-collapse collapse"
                            :class="{'show': showAccordion5 }"
                       >
                           <div class="accordion-body">
                               <p>Да, с доплатой 80 гривен возможно сделать распаровку комплекта</p>
                           </div>
                       </div>
                   </div>

                   <div class="accordion-item">
                       <h2 class="accordion-header">
                           <button class="accordion-button"
                                   type="button"
                                   @click="showAccordion6Func"
                                   :class="{'collapsed' : !showAccordion6,'collaps' : showAccordion6}"
                           >
                               Почему я при получении посылки на Новой почте просят оплатить комиссию?
                           </button>
                       </h2>
                       <div class="accordion-collapse collapse"
                            :class="{'show': showAccordion6 }"
                       >
                           <div class="accordion-body">
                               <p>При оформлении заказа способом оплаты вы выбрали “наложенный платеж”, что подразумевает оплату
                                   комиссии за услуги Новой почты при переводе денег. Так при получении посылки оплачиваете заказ,
                                   стоимость доставки и комиссию за наложенный платеж (20 грн + 2% от суммы заказа).
                               </p>
                           </div>
                       </div>
                   </div>

                   <div class="accordion-item">
                       <h2 class="accordion-header">
                           <button class="accordion-button"
                                   type="button"
                                   @click="showAccordion7Func"
                                   :class="{'collapsed' : !showAccordion7,'collaps' : showAccordion7}"
                           >
                               Нужна ли предоплата для доставки заказа?
                           </button>
                       </h2>
                       <div class="accordion-collapse collapse"
                            :class="{'show': showAccordion7 }"
                       >
                           <div class="accordion-body">
                               <p>Мы просим оплатить минимальную предоплату 90 гривен. Мы сталкнулись с проблемой что многие
                                   клиенты заказывают товар и после оформления не приходят на почту и не берут трубку. Предоплата
                                   нужна как гарантия того, что вы заберете товар на почте или хотя бы осмотрите посылку. Сумма
                                   предоплаты вычитается из финальной, таким образом вы не переплчиваете!
                               </p>
                           </div>
                       </div>
                   </div>
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
            showAccordion3: false,
            showAccordion4: false,
            showAccordion5: false,
            showAccordion6: false,
            showAccordion7: false,
        }
    },
    methods: {
        showAccordion1Func() {
            this.showAccordion1 = !this.showAccordion1;
        },
        showAccordion2Func() {
            this.showAccordion2 = !this.showAccordion2;
        },
        showAccordion3Func() {
            this.showAccordion3 = !this.showAccordion3;
        },
        showAccordion4Func() {
            this.showAccordion4 = !this.showAccordion4;
        },
        showAccordion5Func() {
            this.showAccordion5 = !this.showAccordion5;
        },
        showAccordion6Func() {
            this.showAccordion6 = !this.showAccordion6;
        },
        showAccordion7Func() {
            this.showAccordion7 = !this.showAccordion7;
        },
    }
}
</script>
