<?php

use function Livewire\Volt\{state, layout};

layout('components.layouts.web');
?>

<div class="space-y-10">
    <section class="space-y-10 flex flex-col items-center justify-center">
        <div class="p-3 rounded-full bg-emerald-100/50 dark:bg-emerald-100/0">
            <flux:icon.hand-platter class="text-emerald-600 dark:text-emerald-400" />
        </div>
        
        <hgroup class="space-y-3">
            <h1 class="md:text-6xl text-4xl font-serif text-center text-emerald-600 dark:text-emerald-400 font-bold md:leading-18">Our Services</h1>
            <flux:text class="text-base text-center max-w-sm mx-auto font-semibold">A juicy lechon is perfect for any occasion!</flux:text>
        </hgroup>
    </section>

    <section class="grid sm:grid-cols-2 md:grid-cols-3 gap-5">
        <div class="p-5 rounded-lg border border-zinc-200 dark:border-zinc-700 dark:bg-zinc-700/50 space-y-5">
            <flux:icon.hand-platter />

            <hgroup>
                <flux:heading size="lg">Lorem ipsum dolor sit.</flux:heading>
                <flux:subheading>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia est amet cumque, deleniti quos adipisci laborum! Tempore quam obcaecati optio?</flux:subheading>
            </hgroup>
        </div>
        <div class="p-5 rounded-lg border border-zinc-200 dark:border-zinc-700 dark:bg-zinc-700/50 space-y-5">
            <flux:icon.hand-platter />

            <hgroup>
                <flux:heading size="lg">Lorem ipsum dolor sit.</flux:heading>
                <flux:subheading>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia est amet cumque, deleniti quos adipisci laborum! Tempore quam obcaecati optio?</flux:subheading>
            </hgroup>
        </div>
        <div class="p-5 rounded-lg border border-zinc-200 dark:border-zinc-700 dark:bg-zinc-700/50 space-y-5">
            <flux:icon.hand-platter />

            <hgroup>
                <flux:heading size="lg">Lorem ipsum dolor sit.</flux:heading>
                <flux:subheading>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia est amet cumque, deleniti quos adipisci laborum! Tempore quam obcaecati optio?</flux:subheading>
            </hgroup>
        </div>
    </section>

    <section class="space-y-5">
        <hgroup>
            <flux:heading size="xl">Frequently Asked Questions</flux:heading>
            <flux:subheading class="max-w-sm">If you have any other questions not answered in this FAQs, feel free to call or text our number <flux:link href="tel:+639172081519">+63 917 208 1519</flux:link>, or send a message on our <flux:link href="https://www.facebook.com/millers.lechon24" external>facebook</flux:link> page.</flux:subheading>
        </hgroup>

        <flux:accordion>
            <flux:accordion.item heading="How to order a Lechon?">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sint aliquam modi repellendus voluptatem aspernatur aperiam porro vel ducimus, doloribus commodi!
            </flux:accordion.item>
            <flux:accordion.item heading="Do you deliver Lechon outside the Province of Rizal?">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum autem, ullam quibusdam rem nihil, impedit natus beatae, nesciunt vero accusamus eaque. Sed tempora sint adipisci voluptatibus, expedita quod aliquam debitis.
            </flux:accordion.item>
            <flux:accordion.item heading="Do you accept PWD and Senior Citizen Cards for discounts?">
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Officiis tempore illo reprehenderit, aut illum exercitationem voluptatibus, porro nobis quo ipsum similique ipsam perspiciatis autem accusamus?
            </flux:accordion.item>
            <flux:accordion.item heading="I did not receive an email, how can I confirm my order?">
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Officiis tempore illo reprehenderit, aut illum exercitationem voluptatibus, porro nobis quo ipsum similique ipsam perspiciatis autem accusamus?
            </flux:accordion.item>
        </flux:accordion>
    </section>
</div>
