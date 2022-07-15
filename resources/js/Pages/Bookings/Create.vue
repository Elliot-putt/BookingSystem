<template>
    <Head>
        <title>Home</title>
        <meta type="description" content="Information about my homepage" head-key="description">
    </Head>
    <h3 class="mb-5">Create a booking for <span class="fw-bold" v-text="service.title"></span> - Select a slot </h3>
    <div class="position-absolute card shadow p-4">
        <p class="m-0 p-0">Key:</p>
        <p class="d-inline-flex my-auto"><span class="mx-2 my-auto px-2 py-2 bg-red"></span> <i
            class="fa-solid fa-circle-arrow-right my-auto mx-2"></i> Current Day</p>
        <p class="d-inline-flex my-auto"><span class="mx-2 my-auto px-2 py-2 bg-blue"></span> <i
            class="fa-solid fa-circle-arrow-right my-auto mx-2"></i> Active Day</p>
    </div>
    <div class="font-sans text-gray-900 antialiased d-flex">
        <div class="card shadow  h-50 w-50 mx-auto my-auto row justify-content-center">
            <div class="card-body">
                <div id="calender">
                    <div class="month">
                        <ul>
                            <li class="prev"><a href="#" v-show="!form.processing" @click.prevent="prev">&#10094;</a>
                            </li>
                            <li class="next"><a href="#" v-show="!form.processing" @click.prevent="next">&#10095;</a>
                            </li>
                            <!--                            foreach month in months  | foreach day in days -->
                            <li v-text="monthName+ ' ' + year"></li>
                        </ul>
                    </div>
                    <ul class="weekdays">
                        <li>Mo</li>
                        <li>Tu</li>
                        <li>We</li>
                        <li>Th</li>
                        <li>Fr</li>
                        <li>Sa</li>
                        <li>Su</li>
                    </ul>
                    <ul class="days">
                        <!--offset days-->
                        <li v-for="(days , index) in startDays "></li>
                        <!--days in month if form is not processing-->
                        <li v-for="(date , index) in daysAmount" v-if="!form.processing">
                            <Link v-show="!form.processing" as="a" @click.prevent="select(date)" v-text="date"
                                  class="text-secondary btn"
                                  :class="[(classList(date)) , (date === day ? 'selected-day' : '')]"/>
                        </li>
                        <!--disables button if form is processing-->
                        <li v-for="(date , index) in daysAmount" v-if="form.processing">
                            <Link v-show="form.processing" as="a" v-text="date"
                                  class="text-secondary btn disabled cursor-blocked" :class="classList(date)"/>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <div id="times" v-if="times" class="row mt-5 justify-content-center mx-auto w-50">
        <div v-for="time in times" :class="times.length == 1 ? 'col-md-12' :'col-md-2'" class="text-center mx-2 my-2  ">
            <button class="booking-button" @click="book($event.target , time)" v-text="time"></button>
        </div>
        <div v-show="times.length < 1"
             @click="flash('No Slots Available' , 'There are no slots available for this time!','error' )"
             class="text-center col-4 mx-2 my-2  ">
            <button class="booking-button-disabled disabled cursor-none">No Slots Available</button>
        </div>
    </div>
    <div v-show="confirm" class="row mt-5 justify-content-center mx-auto w-50">
        <div class="card shadow">
            <div class="card-body">
                <h4 class="text-center" v-text="service.title"></h4>
                <p class="text-center fs-6 text-secondary">Time for: {{ selectedTime }}</p>
                <form class="d-flex justify-content-around" @submit.prevent="submit">
                    <button @click.prevent="cancel" :class="form.processing ? 'disabled' : ''" class="btn btn-red ">
                        <i class="fa-solid fa-xmark"></i> Cancel/Decline<span v-show="form.processing"
                                                                              class="spinner-border spinner-border-sm"
                                                                              role="status" aria-hidden="true"></span>
                    </button>
                    <button type="submit" :class="form.processing ? 'disabled' : ''" class="btn btn-green">
                        <i class="fa-solid fa-check"></i> Confirm/Book <span v-show="form.processing"
                                                                             class="spinner-border spinner-border-sm"
                                                                             role="status" aria-hidden="true"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
<script setup>
import {Inertia} from "@inertiajs/inertia";
import {usePage} from '@inertiajs/inertia-vue3'
import {useForm} from "@inertiajs/inertia-vue3"
import {useFlash} from "../../Composables/useFlash";
import {computed} from 'vue'
import {ref} from "vue";

let emit = defineEmits(["select"]);

defineProps({
    times: Array,
    daysAmount: Array,
    startDays: Number,
    today: String,
    isPast: Boolean,
    month: String,
    monthName: String,
    year: String,
    day: String,
    now: String,
    nextMonth: String,
    prevYear: String,
    prevMonth: String,
    company: Object,
    service: Object,
    dateBooked: String,
    duration: String,
});
let page = usePage().props.value;
let confirm = ref(false);
let selectedTime = ref('');
let dateBooked = ref(page.dateBooked);
let {flash} = useFlash();


let form = useForm({
    company: page.company.id,
    service: '',
    email: page.auth.user.email,
    date: dateBooked,
    time: selectedTime,
    duration: page.duration,
});
//post the booking
let submit = () => {
    flash('success', 'Your Booking has been successful')
    form.post(`/booking/store/${page.company.id}/${page.service.id}/`, form);
}
//cancel the booking
let cancel = () => {
    confirm.value = false;
}
//changes month backwards
let prev = () => {
    Inertia.get(`/booking/${page.company.id}/${page.service.id}/${page.prevMonth}/${page.prevYear}/`);
}
//changes month forward
let next = () => {
    Inertia.get(`/booking/${page.company.id}/${page.service.id}/${page.nextMonth}/${page.nextYear}/`);
}
//this gets the times that the company is available for bookings
let select = (date) => {
    Inertia.get(`/booking/times/${page.company.id}/${page.service.id}/${date}/${page.month}/${page.year}/${page.duration}/#times`, {
        preserveState: true,
    });

}
//button/time clicked
let book = (e, time) => {
    let timesDiv = e.parentElement.parentElement;
    timesDiv.classList.add('d-none');
    confirm.value = true;
    selectedTime.value = time;
}
//returns if the date is passed
const isPast = (date) => {
    return Date.parse(date) - Date.parse(new Date()) < 0
};
//determines if date is in the past then returns the appropriate classes
const classList = computed(async => (date) => {
    let className = '';
    if (date + page.month + page.year === page.today) {
        className = 'active-day'
    } else if (isPast(`${page.month}/${date}/${page.year}`)) {
        className = 'disabled';
    }
    return className;
});


</script>

