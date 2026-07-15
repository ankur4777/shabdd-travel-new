(function(){
  const carousel = document.querySelector('[data-testimonial-carousel]');
  if(!carousel) return;

  const track = carousel.querySelector('[data-carousel-track]');
  const prevBtn = carousel.querySelector('.st-carousel-nav--prev');
  const nextBtn = carousel.querySelector('.st-carousel-nav--next');
  const dotsWrap = carousel.querySelector('[data-carousel-dots]');

  const cards = Array.from(track ? track.querySelectorAll('[data-tcard]') : []);
  if(!track || cards.length === 0) return;

  function cardWidth(){
    const first = cards[0];
    if(!first) return 1;
    const style = getComputedStyle(track);
    const gap = parseFloat(style.gap || '18') || 18;
    return first.getBoundingClientRect().width + gap;
  }

  function getActiveIndex(){
    const step = cardWidth();
    const left = track.scrollLeft;
    return Math.round(left / step);
  }

  function maxDots(){
    // snap: number of possible starting positions
    const step = cardWidth();
    const max = Math.max(0, Math.ceil((track.scrollWidth - track.clientWidth) / step));
    return max + 1;
  }

  function buildDots(){
    const total = maxDots();
    dotsWrap.innerHTML='';
    for(let i=0;i<total;i++){
      const d=document.createElement('button');
      d.type='button';
      d.className='st-dot'+(i===0?' st-dot--active':'');
      d.setAttribute('aria-label', `Go to testimonial ${i+1}`);
      d.addEventListener('click', ()=>{
        const step = cardWidth();
        track.scrollTo({left: i*step, behavior:'smooth'});
      });
      dotsWrap.appendChild(d);
    }
  }

  function updateDots(){
    const idx = Math.max(0, Math.min(cards.length-1, getActiveIndex()));
    Array.from(dotsWrap.children).forEach((d,i)=>{
      d.classList.toggle('st-dot--active', i===idx);
    });
  }

  function stepScroll(dir){
    const step = cardWidth();
    track.scrollBy({left: dir*step, behavior:'smooth'});
  }

  prevBtn && prevBtn.addEventListener('click', ()=>stepScroll(-1));
  nextBtn && nextBtn.addEventListener('click', ()=>stepScroll(1));

  let resizeTimer;
  window.addEventListener('resize', ()=>{
    clearTimeout(resizeTimer);
    resizeTimer=setTimeout(()=>{buildDots(); updateDots();}, 120);
  });

  track.addEventListener('scroll', ()=>{
    window.requestAnimationFrame(updateDots);
  });

  buildDots();
  updateDots();

  // Read more modal
  const modalEl = document.getElementById('stReadMoreModal');
  const bsModal = modalEl ? new bootstrap.Modal(modalEl) : null;
  carousel.querySelectorAll('[data-readmore]').forEach(a=>{
    a.addEventListener('click', (e)=>{
      e.preventDefault();
      if(!bsModal) return;
      const text = a.closest('[data-tcard]')?.querySelector('.st-tcard__text')?.textContent;
      const p = modalEl?.querySelector('.st-readmore-modal__text');
      if(p && text) p.textContent = text + ' We truly appreciate your trust and look forward to planning more journeys with you.';
      bsModal.show();
    });
  });
})();

