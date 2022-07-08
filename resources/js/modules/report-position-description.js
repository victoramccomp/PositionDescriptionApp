const init = () => {
    // prevent run if not on correct route
    const validPath = () => {
        const routes = ['/positiondescription/report']
        for (const route of routes) {
            if (~window.location.pathname.indexOf(route)) return true
        }
        return false
    }
    if (!validPath()) return

    /** toggle menu items */
    const activeToggle = () => {

        /** animate */
        const animate = ({
            mod,
            target
        }) => {
            const key = target.dataset.toggle
            const menu = document.querySelector(`#${key}`)

            // set max to zero
            let max = 0

            // if a mod was passed
            if (mod) {
                // set max as the sum of all menu childs height plus margin top/bottom
                ;
                [...menu.children].forEach(child => {
                    max += child.clientHeight

                    // this get the correct margin top/bottom value
                    max += parseInt(window.getComputedStyle(child).getPropertyValue('margin-top'))
                    max += parseInt(window.getComputedStyle(child).getPropertyValue('margin-bottom'))
                })
            }


            // call animejs to toggle the menu
            
            if ( menu !== null )
                menu.style.height = (max * mod) + 'px'; // cuz mod can be either 1 or 0
        }

        /** close all opened menus */
        const closeAll = target => {
            const parent = target.parentElement.parentElement
            const actived = parent.querySelector('.active')

            // prevent errors
            if (!actived) return

            // close previous opened mene
            actived.classList.remove('active')
            animate({
                mod: 0,
                target: actived
            })
        }

        /** toogle menu */
        const toggle = e => {
            const target = e.target

            // close actual menu if opened
            if ([...target.classList].includes('active')) return closeAll(target)

            // close any other menu opened
            closeAll(target)

            // open current menu
            target.classList.add('active')
            animate({
                mod: 1,
                target: target
            })
        }

        // add event listener
        ;
        [...document.querySelectorAll('.js-toggle')].forEach(el => {
            ;[...el.querySelectorAll('.toggle')].forEach(btn => {
                // prevent duplicate
                if (btn.dataset.togglefn === 'true') return

                btn.addEventListener('click', toggle, true)
                btn.setAttribute('data-togglefn', 'true')

                const span = btn.querySelector('span')
                const small = btn.querySelector('small')

                span.style.pointerEvents = 'none'
                small.style.pointerEvents = 'none'
            })
        })
    }

    activeToggle();

    console.log('report env')
}

export default init
