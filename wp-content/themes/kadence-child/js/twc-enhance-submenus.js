document.addEventListener('DOMContentLoaded', function () {
    const complexLayoutIds = {
        1908: {
            title: 'The Foam Hub',
            description: 'Expert insights to help you choose the right foam for every application. Confidence in every cut.',
            discoverLink: '/foam-hub',
            sizeCharts: [
                { text: 'Data Sheets', url: '#' },
                { text: 'Flammability Reports', url: '#' }
            ],
            buyingGuides: [
                { text: 'Polyurethane Foam', url: '#' },
                { text: 'Memory Foam', url: '#' },
                { text: 'Reconstituted Foam', url: '#' },
                { text: 'Standard Cushions', url: '#' },
                { text: 'Ezi Dri Reticulated Foam', url: '#' },
                { text: 'Gravidry Reticulated', url: '#' },
                { text: 'Closed Cell Foam', url: '#' },
                { text: 'Scrim Foam', url: '#' },
            ]
        },

        1907: {
            title: 'Cushion Hub',
            description: 'Expert guidance on choosing the right filling, wrap, and support layers for cushions and upholstery. Confidence in every cut and stitch.',
            discoverLink: '/cushion-hub',
            sizeCharts: [
                { text: 'Dacron GSM Charts', url: '#' },
                { text: 'Filling Makeup', url: '#' },
                { text: 'Fire Retardant Info', url: '#' },
                { text: 'Feather Content', url: '#' },
                { text: 'Recyclability Info', url: '#' }
            ],
            buyingGuides: [
                { text: 'Fibre vs Feather Cushions', url: '#' },
                { text: 'Dacron Weight Guide', url: '#' },
                { text: 'Stockinette Type & Uses', url: '#' },
                { text: 'Choosing the Right Filling', url: '#' },
                { text: 'Cushion Size & Applications', url: '#' },
            ]
        },
        
        1906:{
            title: 'Hardware Hub',
            description: 'Practical insights for choosing the right structural and fastening components for upholstery work. Durable results, every time.',
            discoverLink: '/hardware-hub',
            sizeCharts: [
                { text: 'Webbing Spec', url: '#' },
                { text: 'Spring Gauge and Load', url: '#' },
                { text: 'Staple Manterial', url: '#' },
                { text: 'Tack Brands', url: '#' },
                { text: 'Button Sizes', url: '#' },
            ],
            buyingGuides: [
                { text: 'Tackstrip Picked Right', url: '#' },
                { text: 'Button Types', url: '#' },
                { text: 'Tacks vs Staples', url: '#' },
                { text: 'Spring Gauge & Coils', url: '#' },
                { text: 'Webbing vs Spring Support', url: '#' },
                { text: 'Press Stud Sizing', url: '#' },
            ]
        },

        1905:{
            title: 'Detailing Hub',
            description: 'Expert advice for perfecting the finishing touches in upholstery — from threads and piping to decorative nails and trimmings.',
            discoverLink: '/detailing-hub',
            sizeCharts: [
                { text: 'Nail Gauge & Length', url: '#' },
                { text: 'Thread Material', url: '#' },
                { text: 'Cord Sizing', url: '#' },
                { text: 'Piping Cord Profiles', url: '#' },
            ],
            buyingGuides: [
                { text: 'Thread Types', url: '#' },
                { text: 'Decorative Nails', url: '#' },
                { text: 'Piping Cord Usage', url: '#' },
                { text: 'Blind Seam Profiles', url: '#' },
                { text: 'The Right Twine', url: '#' },
                { text: 'Trimming Finishes', url: '#' },
            ]
        },

        1903: {
            title: 'Equipment Hub',
            description: 'Tips and guidance on using essential tools and materials for upholstery work — from adhesives and chalk to shears and staple removers.',
            discoverLink: '/equipment-hub',
            sizeCharts: [
                { text: 'Adhesives Data Sheets', url: '#' },
                { text: 'Needle & Pin Gauges', url: '#' },
                { text: 'Air Gun Pressure Ranges', url: '#' },
                { text: 'Needle Compatibility', url: '#' },
                { text: 'Stapler & Chisel Gauges', url: '#' },
            ],
            buyingGuides: [
                { text: 'The Right Shears', url: '#' },
                { text: 'Needle Types and Applications', url: '#' },
                { text: 'Adhesive Types', url: '#' },
                { text: 'Fabric Marking', url: '#' },
                { text: 'Air Guns vs Hands-On', url: '#' },
                { text: 'Tufting Tooling', url: '#' },
            ]
        },

        1902: {
            title: 'Linings & Backings Hub',
            description: 'Expert guidance on choosing the right base materials and vinyls for durability, finish, and fire safety — from platform linings to professional-grade vinyl.',
            discoverLink: '/lining-backing-hub',
            sizeCharts: [
                { text: 'Flammability Compliance', url: '#' },
                { text: 'Thickness & Weight Charts', url: '#' },
                { text: 'Material Composition', url: '#' },
            ],
            buyingGuides: [
                { text: 'Fabric Care', url: '#' },
                { text: 'General Applications', url: '#' },
                { text: 'The Right Lining', url: '#' },
                { text: 'Vinyl or Fabric', url: '#' },
                { text: 'Underneath the Sofa ', url: '#' },
            ]
        },

        1901:{
            title: 'Leg & Castor Hub',
            description: 'Simple, practical advice for picking the right furniture feet, castors, and glides — whatever the style or surface.',
            discoverLink: '/leg-castor-hub',
            sizeCharts: [
                { text: 'Load Ratings', url: '#' },
                { text: 'Glide Diameter Reference', url: '#' },
                { text: 'Material Types', url: '#' },
                { text: 'Sizes and Weights', url: '#' },
            ],
            buyingGuides: [
                { text: 'Fixing Types Explained', url: '#' },
                { text: 'Feet, Castors, Legs or Glides?', url: '#' },
                { text: 'Wood or Metal?', url: '#' },
                { text: 'Floor Surface Suitability', url: '#' },
            ]
        },

        1900: {
            title: 'The Packaging Hub',
            description: 'Everything you need to keep products secure, clean, and clearly labelled from dispatch to delivery.',
            discoverLink: '/packaging-hub',
            sizeCharts: [
                { text: 'Weight Capacities', url: '#' },
                { text: 'Tensile Stength Chart', url: '#' },
                { text: 'Cardboard Micron Chart', url: '#' },
            ],
            buyingGuides: [
                { text: 'Chair & Settee Bags', url: '#' },
                { text: 'Labelling Right', url: '#' },
                { text: 'Film Wrap vs Silk Wrap', url: '#' },
                { text: 'Fragile or Tough? ', url: '#' },
            ]
        }

        // Add more menu items as needed
    };

    document.querySelectorAll('.menu-item.has-submenu').forEach(menuItem => {
        const itemId = parseInt(menuItem.getAttribute('data-item-id'), 10);
        const layout = complexLayoutIds[itemId];
        if (!layout) return;

        const panel = menuItem.querySelector('.sub-menu-image-panel');
        if (!panel) return;

        const layoutWrapper = document.createElement('div');
        layoutWrapper.className = 'thread-sleep-layout';

        layoutWrapper.innerHTML = `
            <div class="thread-sleep-content">
                <h3>${layout.title}</h3>
                <p>${layout.description}</p>
                <a href="${layout.discoverLink}" class="discover-link">DISCOVER MORE</a>
            </div>
            <div class="thread-sleep-lists">
                <div class="thread-sleep-column">
                    <h4>Specifications</h4>
                    <ul>
                        ${layout.sizeCharts.map(link => `<li><a href="${link.url}">${link.text}</a></li>`).join('')}
                    </ul>
                </div>
                <div class="thread-sleep-column-left">
                    <h4>Buying guides</h4>
                    <ul>
                        ${layout.buyingGuides.map(link => `<li><a href="${link.url}">${link.text}</a></li>`).join('')}
                    </ul>
                </div>
            </div>
        `;

        panel.appendChild(layoutWrapper);
    });
});
