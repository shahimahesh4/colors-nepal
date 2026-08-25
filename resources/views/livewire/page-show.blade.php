<div>
    <x-page-banner :title="$page->title" :description="$page->excerpt" />

    <section class="brand-surface py-16 sm:py-20">
        <article class="brand-panel mx-auto max-w-4xl rounded-feature border border-brand-100 bg-white px-6 py-10 shadow-card sm:px-10 sm:py-12">
            <div class="space-y-5 text-base leading-8 text-slate-700 [&_a]:font-semibold [&_a]:text-brand-700 [&_blockquote]:border-l-4 [&_blockquote]:border-creative-pink [&_blockquote]:pl-5 [&_h2]:pt-5 [&_h2]:text-2xl [&_h2]:font-bold [&_h2]:text-ink-950 [&_h3]:pt-4 [&_h3]:text-xl [&_h3]:font-bold [&_h3]:text-ink-950 [&_li]:ml-5 [&_li]:list-disc">
                {!! $page->content !!}
            </div>
        </article>
    </section>
</div>
