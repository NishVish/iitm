function buildPage(page) {
const isCover = page.category === 'Cover Page';
const isLastPage = page.category === 'lastpage';

const wrap = document.createElement('div');
wrap.className = 'page' + (isCover ? ' cover-page' : '');

/* ───────── COVER PAGE (BLADE STAYS AS IS) ───────── */
if (isCover) {
@include('web.sponsorship.pagecomponents.cover')
return wrap;
}@include('web.sponsorship.pagecomponents.lastpage')

@include('web.sponsorship.pagecomponents.footer')


/* ───────── CONTENT PAGE (BLADE STAYS AS IS) ───────── */
@include('web.sponsorship.pagecomponents.content')

return wrap;
}