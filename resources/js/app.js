/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import Tone from 'tone';
import WaveSurfer from 'wavesurfer.js';

const app = createApp({});

// Buat objek player untuk memainkan audio
const player = new Tone.Player('path/to/audio.mp3').toDestination();

// Mulai memainkan audio
player.start();

// Buat efek tremolo
const tremolo = new Tone.Tremolo().toDestination();

// Terapkan efek tremolo ke player
player.connect(tremolo);

// Mulai efek tremolo
tremolo.start();

// Daftarkan komponen contoh
import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

// Pasang aplikasi pada elemen dengan id "app"
app.mount('#app');

export { WaveSurfer };