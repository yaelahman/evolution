<?php
$step = $_GET['step'] ?? 1;
?>
<div class="flex flex-col justify-between h-full 2xl:ps-12">
    <div class="flex flex-col gap-1">
        <div class="mb-8">
            <img src="./assets/images/logo.png" alt="">
        </div>
        <div class="flex w-full rounded-xl px-4 py-3 gap-3 <?= $step == 1 ? 'bg-white' : '' ?>">
            <div
                class="rounded-full <?= $step >= 1 ? 'bg-primaryGradient text-white' : 'border border-secondary text-secondary' ?> h-8 w-8 ps-[8px] pt-[5px] lg:text-sm text-sm my-auto">
                <p><?= $step > 1 ? '<i class="fas fa-check"></i>' : '01' ?></p>
            </div>
            <div class="text-start">
                <small class="text-muted">
                    Step 1
                </small>
                <h6 class="text-header font-medium">Scope of Work & Photos</h6>
            </div>
        </div>
        <div class="flex w-full rounded-xl px-4 py-3 gap-3 <?= $step == 2 ? 'bg-white' : '' ?>">
            <div
                class="rounded-full <?= $step >= 2 ? 'bg-primaryGradient text-white' : 'border border-secondary text-secondary' ?> h-8 w-8 <?= $step > 2 ? 'ps-[8px] pt-[5px]' : 'ps-[6px] pt-[5px]' ?> lg:text-sm text-sm my-auto">
                <p><?= $step > 2 ? '<i class="fas fa-check"></i>' : '02' ?></p>
            </div>
            <div class="text-start">
                <small class="text-muted">
                    Step 2
                </small>
                <h6 class="text-header font-medium">Floor Plans</h6>
            </div>
        </div>
        <div class="flex w-full rounded-xl px-4 py-3 gap-3 <?= $step == 3 ? 'bg-white' : '' ?>">
            <div
                class="rounded-full <?= $step >= 3 ? 'bg-primaryGradient text-white' : 'border border-secondary text-secondary' ?> h-8 w-8 <?= $step > 3 ? 'ps-[8px] pt-[5px]' : 'ps-[6px] pt-[5px]' ?> lg:text-sm text-sm my-auto">
                <p><?= $step > 3 ? '<i class="fas fa-check"></i>' : '03' ?></p>
            </div>
            <div class="text-start">
                <small class="text-muted">
                    Step 3
                </small>
                <h6 class="text-header font-medium">Inspiration Photos</h6>
            </div>
        </div>
        <div class="flex w-full rounded-xl px-4 py-3 gap-3 <?= $step == 4 ? 'bg-white' : '' ?>">
            <div
                class="rounded-full <?= $step >= 4 ? 'bg-primaryGradient text-white' : 'border border-secondary text-secondary' ?> h-8 w-8 <?= $step > 4 ? 'ps-[8px] pt-[5px]' : 'ps-[6px] pt-[5px]' ?> lg:text-sm text-sm my-auto">
                <p><?= $step > 4 ? '<i class="fas fa-check"></i>' : '04' ?></p>
            </div>
            <div class="text-start">
                <small class="text-muted">
                    Step 4
                </small>
                <h6 class="text-header font-medium">Final</h6>
            </div>
        </div>
    </div>
    <div class="bg-white p-8 rounded-xl">
        <h6 class="text-header text-lg font-semibold mb-3">
            Do you have any questions?
        </h6>
        <p class="text-muted text-sm">
            If you want to discuss the project by phone, leave your number and we will call you back.
            Our friendly customer service team is here for you!
        </p>
        <ul class="mt-3">
            <li class="flex items-center text-secondary">
                <span class="h-2 w-2 bg-primary rounded-full mr-2"></span> <a href="">Request a call</a>
            </li>
        </ul>
    </div>
</div>