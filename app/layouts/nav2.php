<?php
$step = $_GET['step'] ?? 1;
?>
<div class="flex flex-col justify-between min-h-[600px] h-full 2xl:ps-12">
    <div class="flex flex-col gap-1">
        <div class="mb-8">
            <img src="./assets/images/logo.png" class="h-8" alt="">
        </div>
        <a href="?step=1" class="flex w-full rounded-xl px-4 py-3 gap-3 hover:bg-primary hover:bg-opacity-10 cursor-pointer <?= $step == 1 ? 'bg-white' : '' ?>">
            <div
                class="rounded-full <?= $step >= 1 ? 'bg-primaryGradient text-white' : 'border border-secondary text-secondary' ?> h-8 w-8 ps-[11px] pt-[6px] lg:text-sm text-sm my-auto">
                <p><?= $step > 1 ? '<i class="fas fa-check"></i>' : '01' ?></p>
            </div>
            <div class="text-start">
                <small class="text-muted">
                    Step 1
                </small>
                <h6 class="text-header font-medium 2xl:text-lg text-xs">Scope of Work & Photos</h6>
            </div>
        </a>
        <a href="?step=2" class="flex w-full rounded-xl px-4 py-3 gap-3 hover:bg-primary hover:bg-opacity-10 cursor-pointer <?= $step == 2 ? 'bg-white' : '' ?>">
            <div
                class="rounded-full <?= $step >= 2 ? 'bg-primaryGradient text-white' : 'border border-secondary text-secondary' ?> h-8 w-8 <?= $step > 2 ? 'ps-[10px] pt-[6px]' : 'ps-[8px] pt-[6px]' ?> lg:text-sm text-sm my-auto">
                <p><?= $step > 2 ? '<i class="fas fa-check"></i>' : '02' ?></p>
            </div>
            <div class="text-start">
                <small class="text-muted">
                    Step 2
                </small>
                <h6 class="text-header font-medium 2xl:text-lg text-xs">Floor Plans</h6>
            </div>
        </a>
        <a href="?step=3" class="flex w-full rounded-xl px-4 py-3 gap-3 hover:bg-primary hover:bg-opacity-10 cursor-pointer <?= $step == 3 ? 'bg-white' : '' ?>">
            <div
                class="rounded-full <?= $step >= 3 ? 'bg-primaryGradient text-white' : 'border border-secondary text-secondary' ?> h-8 w-8 <?= $step > 3 ? 'ps-[10px] pt-[6px]' : 'ps-[6px] pt-[6px]' ?> lg:text-sm text-sm my-auto">
                <p><?= $step > 3 ? '<i class="fas fa-check"></i>' : '03' ?></p>
            </div>
            <div class="text-start">
                <small class="text-muted">
                    Step 3
                </small>
                <h6 class="text-header font-medium 2xl:text-lg text-xs">Inspiration Photos</h6>
            </div>
        </a>
        <a href="?step=4" class="flex w-full rounded-xl px-4 py-3 gap-3 hover:bg-primary hover:bg-opacity-10 cursor-pointer <?= $step == 4 ? 'bg-white' : '' ?>">
            <div
                class="rounded-full <?= $step >= 4 ? 'bg-primaryGradient text-white' : 'border border-secondary text-secondary' ?> h-8 w-8 <?= $step > 4 ? 'ps-[10px] pt-[6px]' : 'ps-[6px] pt-[6px]' ?> lg:text-sm text-sm my-auto">
                <p><?= $step > 4 ? '<i class="fas fa-check"></i>' : '04' ?></p>
            </div>
            <div class="text-start">
                <small class="text-muted">
                    Step 4
                </small>
                <h6 class="text-header font-medium 2xl:text-lg text-xs">Final</h6>
            </div>
        </a>
    </div>
    <div class="bg-white 2xl:p-8 p-4 rounded-xl">
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