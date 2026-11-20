<?php

/*
|--------------------------------------------------------------------------
| Progix Digital — static site content
|--------------------------------------------------------------------------
| Single source of truth for every piece of copy, price and contact detail.
| No database: edit this file (and config/posts.php) and the whole site
| updates. Items flagged "PLACEHOLDER" are waiting on the client.
*/

return [

    'name'     => 'Progix Digital',
    'tagline'  => 'We Build. We Grow. We Automate.',
    'locale'   => 'en_US',
    'theme_color' => '#1AC27E',

    // Show small "Sample" chips on placeholder case studies while in draft.
    'draft_mode' => true,

    // Entity / local-SEO signals. PLACEHOLDER: set city + country once the client confirms (leave null to hide).
    'service_area' => 'Serving clients worldwide',
    'location' => ['city' => null, 'country' => null],
    // PLACEHOLDER profile URLs — added to the structured data (sameAs) as soon as they are filled in.
    'profiles' => [
        'upwork'          => null,
        'clutch'          => null,
        'google_business' => null,
    ],

    'contact' => [
        // PLACEHOLDER — Pakistan number supplied later by client; US number to follow.
        'phone_pk'     => '+92 321 4002361',
        'phone_us'     => null,                // PLACEHOLDER — add US number when provided
        'whatsapp'     => '923214002361',      // digits only, international format, no "+"
        'email'        => 'inquiries@progixdigital.com',
        'address'      => null,                // PLACEHOLDER — no address yet; hidden everywhere while null
        'hours'        => 'Mon – Sat · 10:00 – 19:00 (PKT)',
        'calendly'     => null,                // PLACEHOLDER — e.g. https://calendly.com/your-handle/free-consultation
    ],

    'social' => [
        // PLACEHOLDER profile URLs (set to null to hide an icon)
        ['name' => 'Instagram', 'icon' => 'instagram', 'url' => null], // PLACEHOLDER
        ['name' => 'Facebook',  'icon' => 'facebook',  'url' => null], // PLACEHOLDER
        ['name' => 'LinkedIn',  'icon' => 'linkedin',  'url' => null], // PLACEHOLDER
    ],

    // Payment redirect (Stripe / PayPal) — wire in later. Used by "Get started" buttons.
    'checkout' => [
        'enabled' => false,
        'url'     => null,
    ],

    'nav' => [
        ['label' => 'Home',     'route' => 'home'],
        ['label' => 'Services', 'route' => 'services', 'mega' => true],
        ['label' => 'Pricing',  'route' => 'pricing'],
        ['label' => 'Our Work', 'route' => 'clients', 'children' => [
            ['label' => 'Clients',                 'route' => 'clients',      'desc' => 'Brands that trust us'],
            ['label' => 'Reviews & Case Studies',  'route' => 'testimonials', 'desc' => 'Results and 5-star feedback'],
        ]],
        ['label' => 'Insights', 'route' => 'blog'],
        ['label' => 'About',    'route' => 'about'],
        ['label' => 'Contact',  'route' => 'contact'],
    ],

    'stats' => [
        ['value' => 10,    'suffix' => '+', 'label' => 'Years of industry experience'],
        ['value' => 1200,  'suffix' => '+', 'label' => 'Projects completed'],
        ['value' => 23000, 'suffix' => '+', 'label' => 'Hours of dedicated work'],
        ['value' => 37,    'suffix' => '+', 'label' => 'Industries & niches served'],
    ],

    'upwork' => [
        'badge'    => 'Top Rated Plus',
        'success'  => '100%',
        'earnings' => '$200K+',
        'jobs'     => '432',
        'hours'    => '14,517',
        'rating'   => '5.0',
        'url'      => null, // PLACEHOLDER — Upwork profile link
    ],

    /* ------------------------------------------------------------------ */
    /*  Services                                                           */
    /* ------------------------------------------------------------------ */
    'services' => [
        [
            'slug'  => 'social-media-marketing',
            'title' => 'Social Media Marketing',
            'pillar'=> 'Marketing',
            'icon'  => 'megaphone',
            'image' => 'social',
            'short' => 'Content, strategy and community management that keeps your brand active and growing.',
            'from'  => 199,
            'pricing_tab' => 'social',
            'meta_title' => 'Social Media Marketing & Management Services',
            'meta_desc'  => 'Done-for-you social media management: content calendars, posts, reels, community management and monthly analytics. Packages from $199/month.',
            'headline'   => 'Social media that works as hard as you do',
            'lead'       => 'Consistent, on-brand content across Instagram, Facebook, LinkedIn and more — planned, designed, scheduled and reported on by one dedicated team.',
            'body'       => [
                'Most businesses know they should be posting, but few have the time, the strategy or the creative muscle to do it well. We take the whole job off your plate: a monthly content calendar, designed posts, carousels, short-form reels, captions, hashtag and keyword research, scheduling and publishing.',
                'Every plan starts with a clear strategy and road map built around your audience and goals, and ends with a plain-English performance report so you always know what is working and what we are improving next.',
            ],
            'includes' => [
                'Monthly content calendar and road map',
                'Static posts, carousels and short-form reels',
                'Caption writing, hashtag and keyword research',
                'Scheduling, publishing and community management',
                'Competitor content analysis',
                'Monthly analytics with clear next steps',
            ],
            'faqs' => [
                ['Which platforms do you manage?', 'Instagram, Facebook, LinkedIn, TikTok, X (Twitter), YouTube and Pinterest — depending on where your customers actually spend time. Our plans cover 3 to 5 platforms.'],
                ['Do I have to approve every post?', 'You stay in control. We share the monthly content calendar for approval, and each post includes revision rounds so the final result always feels like your brand.'],
                ['How soon will I see results?', 'Most brands see a steadier posting rhythm and better engagement within the first month. Meaningful audience and lead growth typically builds over 3 to 6 months of consistent work.'],
            ],
        ],
        [
            'slug'  => 'paid-advertising',
            'title' => 'Paid Advertising',
            'pillar'=> 'Marketing',
            'icon'  => 'target',
            'image' => 'ads',
            'short' => 'Meta and Google Ads built around measurable outcomes — leads, sales and a lower cost per result.',
            'from'  => 199,
            'pricing_tab' => 'ads',
            'meta_title' => 'Meta Ads & Google Ads Management Services',
            'meta_desc'  => 'Facebook, Instagram and Google Ads management with conversion tracking and monthly optimisation. Management from $199/month.',
            'headline'   => 'Ads that pay for themselves',
            'lead'       => 'Campaigns set up properly, tracked accurately and optimised every month — so every dollar of ad spend is working toward a real business goal.',
            'body'       => [
                'Great advertising is part research, part creative and part relentless optimisation. We handle all three: audience research, campaign structure, ad copy and creative, pixel and conversion tracking, and ongoing monitoring.',
                'You keep full ownership of your ad accounts and your ad spend is paid directly to the platforms — we are fully transparent about where every dollar goes.',
            ],
            'includes' => [
                'Facebook, Instagram and Google Search campaigns',
                'Audience and keyword research',
                'Ad copywriting and basic creative design',
                'Pixel and conversion tracking set-up',
                'Negative keyword management and retargeting',
                'Monthly performance reporting and optimisation',
            ],
            'faqs' => [
                ['Is ad spend included in your price?', 'No. Our fee covers strategy, set-up and management. Ad spend is paid directly by you to Meta or Google — we suggest starting at around $250/month for Meta and $500–$1,000/month for Google.'],
                ['Can you set up ads without ongoing management?', 'Yes. We offer one-time Meta Ads set-up ($99), Google Ads set-up ($149), retargeting and conversion-tracking set-up as stand-alone services.'],
                ['Do you build landing pages for ads?', 'Yes — a conversion-focused landing page built for your campaign is available from $199.'],
            ],
        ],
        [
            'slug'  => 'website-content-seo',
            'title' => 'Website Content & SEO',
            'pillar'=> 'Marketing',
            'icon'  => 'search',
            'image' => 'analytics',
            'short' => 'SEO-friendly copy and keyword strategy that helps the right customers find — and trust — you.',
            'from'  => 99,
            'pricing_tab' => 'content',
            'meta_title' => 'SEO Website Content Writing Services',
            'meta_desc'  => 'Search-optimised website copy, keyword mapping, meta titles and descriptions, blog articles and SEO audits. Packages from $99.',
            'headline'   => 'Words that rank and convert',
            'lead'       => 'Clear, persuasive, search-optimised website copy — researched around the keywords your customers really use.',
            'body'       => [
                'Your website content has two jobs: help search engines understand what you do, and convince visitors to take the next step. We research your market and competitors, map keywords to pages, then write copy that sounds like you and ranks like a pro.',
                'From a five-page starter site to a full ten-page content strategy with landing pages and calls to action, we scope the work clearly up front.',
            ],
            'includes' => [
                'Keyword research and keyword mapping',
                'Home, About, Services, Contact and landing page copy',
                'Meta titles and descriptions for every page',
                'Competitor content research',
                'Blog articles (800–1,000 words) and content audits',
                'Website SEO audits with prioritised fixes',
            ],
            'faqs' => [
                ['Do you write the content for my existing website?', 'Yes. We can rewrite existing pages or write fresh copy for a new site, and deliver it ready to paste into your CMS.'],
                ['What is a keyword map?', 'A document that assigns the best target keyword to every page of your site so pages support each other rather than competing in search results.'],
                ['Can you also publish the content?', 'Absolutely — if we are building or maintaining your website we can publish and format everything for you.'],
            ],
        ],
        [
            'slug'  => 'web-development',
            'title' => 'Web Development',
            'pillar'=> 'Technology',
            'icon'  => 'code',
            'image' => 'web',
            'short' => 'Fast, responsive, conversion-focused websites and web apps — from landing pages to custom platforms.',
            'from'  => 129,
            'pricing_tab' => 'web',
            'meta_title' => 'Custom Website & Web App Development Services',
            'meta_desc'  => 'Responsive landing pages, business websites and advanced web apps with Laravel, React, Next.js and WordPress. From $129. Care plans from $49/month.',
            'headline'   => 'Websites built to perform',
            'lead'       => 'Modern, lightning-fast websites with beautiful design, clean code and SEO built in from the first line.',
            'body'       => [
                'Whether you need a single high-converting landing page, a complete business website or a feature-rich web platform, we design and build it around your customers and your goals — responsive on every device, optimised for speed, and ready to rank.',
                'Our developers work across the modern stack — Laravel, Node.js, Django, React, Next.js, Vue, WordPress, Shopify and more — and we keep your site healthy after launch with affordable monthly care plans.',
            ],
            'includes' => [
                'Custom UI/UX design and responsive development',
                'Contact forms, analytics and social integration',
                'On-page SEO and speed optimisation',
                'Backend, database, authentication and API integrations',
                'WordPress, Shopify and Webflow builds',
                'Maintenance plans: backups, updates and security',
            ],
            'faqs' => [
                ['How long does a website take?', 'A landing page typically takes 3–4 business days, a business website 1–2 weeks, and an advanced website 2–4 weeks depending on functionality.'],
                ['Will my website work on mobile?', 'Yes. Every site we build is mobile-first and tested across phones, tablets and desktops.'],
                ['Who owns the website?', 'You do. On final payment you receive full ownership of the design and code.'],
            ],
        ],
        [
            'slug'  => 'ai-automation',
            'title' => 'AI & Automation',
            'pillar'=> 'Automation',
            'icon'  => 'bot',
            'image' => 'ai',
            'short' => 'AI chatbots, intelligent assistants and workflow automation that give your team hours back every week.',
            'from'  => 99,
            'pricing_tab' => 'ai',
            'meta_title' => 'AI Chatbots & Business Workflow Automation',
            'meta_desc'  => 'Custom AI chatbots, lead qualification and workflow automation with OpenAI, n8n, Make and LangChain. Starting at $99.',
            'headline'   => 'Work smarter with AI',
            'lead'       => 'Intelligent agents and automated workflows that answer customers, qualify leads and run repetitive tasks around the clock.',
            'body'       => [
                'From a simple FAQ chatbot on your website to a fully connected automation system that captures leads, updates your CRM and sends follow-ups on its own, we build practical AI that saves time and increases sales.',
                'Every agent is trained only on client-approved information, tested thoroughly, and deployed with clear handover so your team stays in control.',
            ],
            'includes' => [
                'AI chatbots and intelligent assistants',
                'Custom knowledge bases using your approved content',
                'Lead qualification and automated follow-ups',
                'CRM, form and website integrations',
                'Business process automation with n8n and Make',
                'Testing, deployment and handover',
            ],
            'faqs' => [
                ['Will the chatbot make things up?', 'Our business agents answer from your approved knowledge base and are tested against real customer questions before launch, with clear fallbacks to a human when unsure.'],
                ['Which tools do you integrate with?', 'OpenAI, Google Gemini, LangChain and Pinecone for intelligence, plus n8n and Make to connect your CRM, email, forms, spreadsheets and more.'],
                ['Do I need technical knowledge?', 'No. We handle set-up, testing and deployment, and give you a simple walkthrough.'],
            ],
        ],
        [
            'slug'  => 'creative-branding',
            'title' => 'Creative & Branding',
            'pillar'=> 'Creative',
            'icon'  => 'palette',
            'image' => 'workspace',
            'short' => 'Brand kits, graphics and content design that make your business look as good as it is.',
            'from'  => 69,
            'pricing_tab' => 'social',
            'meta_title' => 'Branding, Brand Kits & Content Design Services',
            'meta_desc'  => 'Brand kits, social media graphics, reels editing and creative direction to make your brand consistent and memorable. From $69.',
            'headline'   => 'A brand people remember',
            'lead'       => 'Logos, colours, typography and content design — brought together into one consistent, recognisable identity.',
            'body'       => [
                'People judge a business in seconds. A cohesive brand kit, polished social graphics and well-edited short-form video build instant credibility and make every other marketing activity work harder.',
                'We create flexible brand systems your whole team can use, then extend them across social media, ads, websites and printed material.',
            ],
            'includes' => [
                'Social media brand kit',
                'Post, carousel and story design',
                'Reels and short-form video editing',
                'Brand-focused creative direction',
                'Ad creative and landing page visuals',
                'Custom quotes for larger branding projects',
            ],
            'faqs' => [
                ['What is in a brand kit?', 'Logo usage, colour palette, typography, social templates and simple guidelines so every post and page looks consistent.'],
                ['Can you redesign my existing logo?', 'Yes — send us a brief and we will provide a custom quote for a logo refresh or full rebrand.'],
                ['Do you design for print too?', 'We can adapt your brand to brochures, cards and packaging on request.'],
            ],
        ],
    ],

    /* ------------------------------------------------------------------ */
    /*  Pricing                                                            */
    /* ------------------------------------------------------------------ */
    'pricing' => [

        'social' => [
            'label' => 'Social Media',
            'icon'  => 'megaphone',
            'title' => 'Social Media Management',
            'intro' => 'Done-for-you content, strategy and reporting. Pick the plan that fits where your brand is today.',
            'plans' => [
                [
                    'tier' => '01', 'name' => 'Starter', 'price' => 199, 'per' => '/ month', 'note' => '≈ $50 per week',
                    'for' => 'Small businesses, startups and individuals who want a consistent social media presence.',
                    'features' => [
                        '20 posts per month',
                        'Static posts, carousels and short-form reels as required',
                        'Management of 3 social media platforms',
                        'Monthly content calendar',
                        'Basic content strategy and road map',
                        'Caption writing and hashtag research',
                        'Scheduling and publishing',
                        'Monthly performance report',
                        'Basic organic growth recommendations',
                        '2 revision rounds per post',
                    ],
                ],
                [
                    'tier' => '02', 'name' => 'Growth', 'price' => 299, 'per' => '/ month', 'note' => '≈ $75 per week', 'popular' => true,
                    'for' => 'Businesses that want to grow their audience and maintain an active presence.',
                    'features' => [
                        '30 posts per month',
                        'Static posts, carousels and reels',
                        'Management of up to 4 social media platforms',
                        'Monthly content calendar',
                        'Customised content strategy and road map',
                        'Captions, hashtags and keyword research',
                        'Scheduling and publishing',
                        'Weekly performance snapshots',
                        'Detailed monthly analytics report',
                        'Community management (up to 30 min / business day)',
                        'Competitor content analysis',
                        '2 revision rounds per post',
                    ],
                ],
                [
                    'tier' => '03', 'name' => 'Premium', 'price' => 499, 'per' => '/ month', 'note' => '≈ $125 per week', 'premium' => true,
                    'for' => 'Established businesses that need comprehensive social media management.',
                    'features' => [
                        '30 posts per month',
                        'Static posts, carousels, reels and up to 4 long-form videos',
                        'Management of up to 5 social media platforms',
                        'Advanced content strategy',
                        'Monthly content calendar and road map',
                        'Brand-focused creative direction',
                        'Captions, hashtags and SEO keyword research',
                        'Scheduling and publishing',
                        'Weekly performance reports',
                        'Comprehensive monthly analytics',
                        'Community management (up to 1 hour / business day)',
                        'Competitor analysis',
                        'Monthly or bi-weekly strategy meeting',
                        'Content performance optimisation',
                        '2–3 revision rounds per post',
                    ],
                ],
            ],
            'addons_title' => 'Add-on social media services',
            'addons_intro' => 'Need just one thing? Buy individual services without a full management package.',
            'addons' => [
                ['Additional 4 static posts', '$19'],
                ['Additional 4 carousel posts', '$29'],
                ['Additional 4 reels (editing only)', '$39'],
                ['Social media account set-up', '$39'],
                ['Social media audit', '$79'],
                ['Monthly content strategy only', '$99'],
                ['Community management', '$129 / mo'],
                ['Influencer research and outreach', '$149 / mo'],
                ['Social media brand kit', '$69'],
                ['Competitor analysis', '$69'],
                ['Extra social media platform', '$49 / mo'],
            ],
        ],

        'ads' => [
            'label' => 'Paid Ads',
            'icon'  => 'target',
            'title' => 'Paid Advertising Management',
            'intro' => 'Performance campaigns on Meta and Google, managed monthly. Ad spend is paid separately by you, directly to the platform.',
            'plans' => [
                [
                    'tier' => '01', 'name' => 'Meta Ads Management', 'price' => 199, 'per' => '/ month', 'note' => 'Suggested ad spend: $250 / month',
                    'for' => 'Facebook and Instagram campaigns built to bring in leads and sales.',
                    'features' => [
                        'Facebook and Instagram campaign set-up',
                        'Audience research',
                        'Campaign objective selection',
                        'Ad copywriting',
                        'Basic creative design',
                        'Pixel and conversion tracking where applicable',
                        'Campaign monitoring and optimisation',
                        'Monthly performance report',
                    ],
                ],
                [
                    'tier' => '02', 'name' => 'Google Ads Management', 'price' => 299, 'per' => '/ month', 'note' => 'Suggested ad spend: $500–$1,000 / month', 'popular' => true,
                    'for' => 'Capture high-intent customers actively searching for what you sell.',
                    'features' => [
                        'Google Ads account and campaign set-up',
                        'Keyword research',
                        'Search campaign creation',
                        'Ad copywriting',
                        'Conversion tracking',
                        'Negative keyword management',
                        'Campaign monitoring and optimisation',
                        'Monthly reporting',
                    ],
                ],
            ],
            'addons_title' => 'One-time advertising services',
            'addons_intro' => 'Set-up only? We will build it properly and hand it over.',
            'addons' => [
                ['Meta Ads set-up only', '$99'],
                ['Google Ads set-up only', '$149'],
                ['Landing page for ads', '$199'],
                ['Retargeting campaign set-up', '$99'],
                ['Conversion tracking set-up', '$99'],
                ['Monthly ads management', 'Custom quote'],
            ],
        ],

        'content' => [
            'label' => 'Content & SEO',
            'icon'  => 'search',
            'title' => 'Website Content & SEO',
            'intro' => 'One-time content projects: SEO-friendly copy written for your customers and for search engines.',
            'plans' => [
                [
                    'tier' => '01', 'name' => 'Website Content Starter', 'price' => 99, 'per' => 'one-time', 'note' => 'Up to 5 pages',
                    'for' => 'Launching a new site or refreshing the essentials.',
                    'features' => [
                        'Up to 5 website pages',
                        'SEO-friendly website copy',
                        'Homepage and About Us content',
                        'Services page content',
                        'Contact page content',
                        'Basic keyword research',
                        'Meta titles and descriptions',
                        'Two revision rounds',
                    ],
                ],
                [
                    'tier' => '02', 'name' => 'Website Content Professional', 'price' => 199, 'per' => 'one-time', 'note' => 'Up to 10 pages', 'popular' => true,
                    'for' => 'A full content strategy built to rank and convert.',
                    'features' => [
                        'Up to 10 website pages',
                        'SEO-focused content research',
                        'Competitor content research',
                        'Keyword mapping',
                        'Homepage, About, Services and landing pages',
                        'Calls to action',
                        'Meta titles and descriptions',
                        'Two revision rounds',
                    ],
                ],
            ],
            'addons_title' => 'Content add-ons',
            'addons_intro' => 'Grow your content library one piece at a time.',
            'addons' => [
                ['Additional page', '$25 – $45'],
                ['Blog article (800–1,000 words)', '$30 – $50'],
                ['Website content audit', '$99'],
                ['Website SEO audit', '$99 – $149'],
            ],
        ],

        'web' => [
            'label' => 'Web Development',
            'icon'  => 'code',
            'title' => 'Website Development',
            'intro' => 'Introductory agency pricing. Exact scope is written into every quotation, so there are never any surprises.',
            'plans' => [
                [
                    'tier' => '01', 'name' => 'Landing Page', 'price' => 129, 'per' => '/ project', 'note' => 'Delivery: 3–4 business days',
                    'for' => 'One powerful page designed to capture leads or promote a single offer.',
                    'features' => [
                        'One professionally designed page',
                        'Responsive mobile and desktop layout',
                        'Contact form',
                        'Basic on-page SEO',
                        'Social media integration',
                        'Basic performance optimisation',
                        '2 revision rounds',
                    ],
                ],
                [
                    'tier' => '02', 'name' => 'Business Website', 'price' => 349, 'per' => '/ project', 'note' => 'Delivery: 1–2 weeks', 'popular' => true, 'badge' => 'Best for small businesses',
                    'for' => 'A custom five-page website that represents your brand and generates enquiries.',
                    'features' => [
                        'Up to 5 pages',
                        'Custom website design',
                        'Responsive development',
                        'Home, About, Services, Contact + 1 extra page',
                        'Contact forms',
                        'Basic SEO set-up',
                        'Google Analytics integration',
                        'Social media integration',
                        'Speed optimisation',
                        '2 revision rounds',
                    ],
                ],
                [
                    'tier' => '03', 'name' => 'Advanced Website', 'price' => 999, 'per' => '/ project', 'note' => 'Delivery: 2–4 weeks', 'premium' => true,
                    'for' => 'Feature-rich websites and web applications with custom functionality.',
                    'features' => [
                        'Up to 10 pages',
                        'Custom UI/UX design',
                        'Advanced front-end development',
                        'Backend functionality where required',
                        'Database integration',
                        'User authentication if required',
                        'API integrations',
                        'Advanced SEO set-up',
                        'Analytics and tracking',
                        'Performance and security optimisation',
                        '3 revision rounds',
                    ],
                ],
            ],
            'stack' => [
                'Front-end'         => ['React.js', 'Next.js', 'Vue.js', 'Angular', 'HTML / CSS / JS', 'Tailwind CSS'],
                'Back-end'          => ['Node.js', 'Django', 'Laravel', 'Express.js', 'ASP.NET', 'FastAPI'],
                'CMS & E-commerce'  => ['WordPress', 'Shopify', 'Webflow'],
                'Databases & Cloud' => ['MySQL', 'PostgreSQL', 'MongoDB', 'Firebase', 'AWS', 'Vercel'],
            ],
            'addons_title' => 'Add-ons',
            'addons_intro' => 'Hosting, domain registration and premium plugins are billed separately at cost.', // ASSUMPTION — source doc line was incomplete
            'addons' => [],
        ],

        'care' => [
            'label' => 'Care Plans',
            'icon'  => 'wrench',
            'title' => 'Website Maintenance',
            'intro' => 'Keep your website fast, secure and up to date — without lifting a finger.',
            'plans' => [
                [
                    'tier' => '01', 'name' => 'Basic Care', 'price' => 49, 'per' => '/ month', 'note' => 'Essential protection',
                    'for' => 'The essentials every website needs.',
                    'features' => ['Regular backups', 'Software and plugin updates', 'Uptime monitoring'],
                ],
                [
                    'tier' => '02', 'name' => 'Standard Care', 'price' => 99, 'per' => '/ month', 'note' => 'Care + content updates', 'popular' => true,
                    'for' => 'Everything in Basic, plus hands-on support.',
                    'features' => ['Everything in Basic Care', 'Content updates', 'Security checks'],
                ],
                [
                    'tier' => '03', 'name' => 'Premium Care', 'price' => 199, 'per' => '/ month', 'note' => 'Priority & development', 'premium' => true,
                    'for' => 'Complete peace of mind with priority support.',
                    'features' => ['Everything in Standard Care', 'Performance monitoring', 'Priority support', '2 hours of minor development'],
                ],
            ],
            'addons_title' => '', 'addons_intro' => '', 'addons' => [],
        ],

        'ai' => [
            'label' => 'AI & Automation',
            'icon'  => 'bot',
            'title' => 'AI & Automation',
            'intro' => 'Practical AI that answers customers, qualifies leads and automates repetitive work.',
            'plans' => [
                [
                    'tier' => '01', 'name' => 'AI Starter Agent', 'price' => 99, 'per' => '/ set-up', 'note' => 'Best for simple website FAQ assistants',
                    'for' => 'A friendly chatbot that answers common questions 24/7.',
                    'features' => ['Basic AI chatbot', 'Predefined FAQs', 'Website integration', 'Basic conversational responses', 'Initial testing'],
                ],
                [
                    'tier' => '02', 'name' => 'AI Business Agent', 'price' => 299, 'per' => '/ set-up', 'note' => 'Knowledge-base powered', 'popular' => true,
                    'for' => 'A trained assistant that qualifies leads and handles customer queries.',
                    'features' => [
                        'Custom-trained knowledge base using client-approved information',
                        'Lead qualification',
                        'Website chatbot integration',
                        'Automated customer queries',
                        'Basic CRM or form integration',
                        'Testing and deployment',
                    ],
                ],
                [
                    'tier' => '03', 'name' => 'AI Automation System', 'price' => 499, 'per' => '/ project', 'note' => 'End-to-end workflows', 'premium' => true,
                    'for' => 'Connected workflows that run your business processes automatically.',
                    'features' => [
                        'Custom AI workflows',
                        'Multiple automation integrations',
                        'CRM integration',
                        'Lead management',
                        'Automated follow-ups',
                        'Business workflow automation',
                        'Advanced testing and deployment',
                    ],
                ],
            ],
            'stack' => [
                'AI & Models'    => ['OpenAI API', 'Google Gemini', 'LangChain', 'Pinecone'],
                'Automation'     => ['n8n', 'Make'],
            ],
            'addons_title' => '', 'addons_intro' => '', 'addons' => [],
        ],
    ],

    /* ------------------------------------------------------------------ */
    /*  Clients (10 supplied logos — shown in colour, 5 per marquee row)   */
    /* ------------------------------------------------------------------ */
    'clients' => [
        ['name' => 'DHL',               'file' => 'dhl',               'w' => 520, 'h' => 83],
        ['name' => 'Platinum Luxury Auctions', 'file' => 'platinum-auctions', 'w' => 520, 'h' => 96],
        ['name' => 'PepsiCo',           'file' => 'pepsico',           'w' => 493, 'h' => 160],
        ['name' => 'Wyzdom AI',         'file' => 'wyzdom-ai',         'w' => 421, 'h' => 359],
        ['name' => 'Livius Prep',       'file' => 'livius-prep',       'w' => 402, 'h' => 297],
        ['name' => 'ZeremAI',           'file' => 'zeremai',           'w' => 456, 'h' => 89],
        ['name' => 'Nickelytics',       'file' => 'nickelytics',       'w' => 327, 'h' => 35],
        ['name' => 'Epique Realty',     'file' => 'epique-realty',     'w' => 520, 'h' => 177],
        ['name' => 'TalentIDO',         'file' => 'talentido',         'w' => 520, 'h' => 119],
        ['name' => 'Viva Floors & More','file' => 'viva-floors',       'w' => 480, 'h' => 251],
        ['name' => 'Georgia Entertainment', 'file' => 'georgia-entertainment', 'w' => 520, 'h' => 160],
        ['name' => 'Vantage Solutions LLC', 'file' => 'vantage-solutions',     'w' => 520, 'h' => 305],
        ['name' => 'Amazon',                'file' => 'amazon',                'w' => 520, 'h' => 292],
        ['name' => 'Nadorra',               'file' => 'nadorra',               'w' => 520, 'h' => 208],
    ],

    // PLACEHOLDER niche list — confirm with client
    'niches' => [
        'E-commerce', 'Real Estate', 'Education', 'Logistics', 'SaaS & AI', 'Recruitment',
        'Luxury & Auctions', 'Home Services', 'Healthcare', 'Hospitality', 'Fintech', 'Retail',
        'Legal', 'Fitness & Wellness', 'Non-profit', 'Consumer Goods',
    ],

    /* ------------------------------------------------------------------ */
    /*  Reviews — transcribed from the client's Upwork feedback            */
    /* ------------------------------------------------------------------ */
    'testimonials' => [
        [
            'quote'   => 'I highly recommend Samin for anyone looking for a skilled and reliable Social Media Manager. He is an excellent communicator who quickly understands the goals and requirements of every project. Throughout the process, he always prioritizes the client\'s needs and delivers work that aligns perfectly with the project\'s objectives. What I appreciate most is his transparency — he keeps everything clear, provides regular updates, and ensures there are no hidden surprises.',
            'project' => 'Social Media Management',
            'tags'    => ['Reliable', 'Committed to Quality', 'Solution Oriented'],
            'featured'=> true,
        ],
        [
            'quote'   => 'Samin was very helpful from the beginning of the project marketing campaign. He gave his attention to understanding our goals and helped us improve our social media presence in a very short period of time. We were able to go from just 40 followers to over 1,000 organically in just a few months. The quality of our media posts were significantly improved and a lot more appealing to our viewers.',
            'project' => 'Social Media Marketing & Ad Campaigns',
            'tags'    => ['Solution Oriented', 'Committed to Quality', 'Clear Communicator'],
            'featured'=> true,
        ],
        [
            'quote'   => 'We worked together on my company\'s ongoing social media posts for 6+ months. Samin was very communicative and diligent in providing relevant posts for our social channels. I would recommend them to anyone looking for marketing assistance.',
            'project' => 'Social Media Manager for Facebook, Instagram & LinkedIn',
            'tags'    => ['Clear Communicator'],
        ],
        [
            'quote'   => 'Easy to work with and very responsive. Also willing to learn new things to try and help. Would rehire. Thank you!',
            'project' => 'Social Media Contract',
            'tags'    => ['Collaborative', 'Clear Communicator', 'Solution Oriented'],
        ],
        [
            'quote'   => 'Very responsive — a great partner during this process and will use him again.',
            'project' => 'Social Media · Personal Branding & Instagram',
            'tags'    => [],
        ],
        [
            'quote'   => 'Very good and reliable work ethics.',
            'project' => 'Social Media Manager',
            'tags'    => ['Reliable'],
        ],
        [
            'quote'   => 'Wonderful to work with Samin.',
            'project' => 'Social Media Management',
            'tags'    => ['Collaborative'],
        ],
        [
            'quote'   => 'Excellent job!',
            'project' => 'Social Media Marketing',
            'tags'    => [],
        ],
    ],

    /* ------------------------------------------------------------------ */
    /*  Case studies — PLACEHOLDER (first one is based on a real review)   */
    /* ------------------------------------------------------------------ */
    'projects' => [
        [
            'slug' => 'organic-growth', 'sample' => false,
            'title' => 'From 40 to 1,000+ followers — organically',
            'category' => 'Social Media Marketing',
            'image' => 'social-2',
            'summary' => 'A fresh brand with almost no audience. A focused content strategy and consistent, higher-quality posting turned a quiet profile into a growing community in just a few months.',
            'results' => [['1,000+', 'organic followers'], ['40', 'starting followers'], ['5.0', 'client rating']],
            'services' => ['Strategy', 'Content design', 'Community'],
        ],
        [
            'slug' => 'lead-gen-ads', 'sample' => true,
            'title' => 'Lead generation campaign for a home-services brand',
            'category' => 'Paid Advertising',
            'image' => 'ads',
            'summary' => 'Meta and Google campaigns with proper conversion tracking, tight audiences and rapid creative testing to lower cost per lead.',
            'results' => [['−38%', 'cost per lead'], ['3.1×', 'return on ad spend'], ['90 days', 'to results']],
            'services' => ['Meta Ads', 'Google Ads', 'Tracking'],
        ],
        [
            'slug' => 'business-website', 'sample' => true,
            'title' => 'A fast, modern website for a growing business',
            'category' => 'Web Development',
            'image' => 'web-2',
            'summary' => 'A custom five-page responsive website with SEO foundations and analytics, replacing an outdated template site.',
            'results' => [['95+', 'PageSpeed score'], ['2×', 'enquiry rate'], ['10 days', 'delivery']],
            'services' => ['UI/UX', 'Laravel', 'SEO'],
        ],
        [
            'slug' => 'ai-support-agent', 'sample' => true,
            'title' => 'AI support agent that never sleeps',
            'category' => 'AI & Automation',
            'image' => 'team-2',
            'summary' => 'A knowledge-base-trained chatbot answering customer questions and qualifying leads straight into the CRM.',
            'results' => [['70%', 'queries automated'], ['24/7', 'availability'], ['< 2 wks', 'to deploy']],
            'services' => ['OpenAI', 'n8n', 'CRM'],
        ],
        [
            'slug' => 'content-seo', 'sample' => true,
            'title' => 'Search-optimised content for a ten-page site',
            'category' => 'Website Content & SEO',
            'image' => 'analytics',
            'summary' => 'Keyword mapping, competitor research and conversion-focused copy for every key page.',
            'results' => [['10', 'pages written'], ['+120%', 'organic traffic'], ['6 mo', 'timeframe']],
            'services' => ['SEO', 'Copywriting', 'Keyword map'],
        ],
        [
            'slug' => 'brand-kit', 'sample' => true,
            'title' => 'Brand kit and social templates',
            'category' => 'Creative & Branding',
            'image' => 'strategy',
            'summary' => 'A complete visual identity system with reusable social templates that keep every post on-brand.',
            'results' => [['12', 'reusable templates'], ['1', 'unified identity'], ['2 wks', 'delivery']],
            'services' => ['Brand kit', 'Templates', 'Reels'],
        ],
    ],

    /* ------------------------------------------------------------------ */
    /*  Process, values, why-us                                            */
    /* ------------------------------------------------------------------ */
    'process' => [
        ['icon' => 'message-circle', 'title' => 'Discover',  'text' => 'A free consultation to understand your business, audience, goals and budget.'],
        ['icon' => 'target',         'title' => 'Strategise','text' => 'A clear scope, road map and fixed price — delivered within 24 hours.'],
        ['icon' => 'layers',         'title' => 'Create',    'text' => 'Our team designs, builds and writes — you review and approve at every step.'],
        ['icon' => 'rocket',         'title' => 'Launch',    'text' => 'We go live, set up tracking and make sure everything works perfectly.'],
        ['icon' => 'trending-up',    'title' => 'Grow',      'text' => 'Monthly reporting, optimisation and support to keep results climbing.'],
    ],

    'why' => [
        ['icon' => 'award',        'title' => 'Proven experience',        'text' => '10+ years of delivering marketing, web and automation projects across 37+ niches.'],
        ['icon' => 'target',       'title' => 'Focused on outcomes',      'text' => 'We measure what matters — leads, sales and growth — not vanity metrics.'],
        ['icon' => 'message-circle','title' => 'Transparent communication','text' => 'Clear updates, honest answers and no hidden surprises, ever.'],
        ['icon' => 'layers',       'title' => 'One team, every service',  'text' => 'Marketing, development and AI under one roof, so everything works together.'],
        ['icon' => 'zap',          'title' => 'Fast turnaround',          'text' => 'Scope and price within 24 hours; landing pages in as little as 3 days.'],
        ['icon' => 'shield-check', 'title' => 'Tailored to your business','text' => 'No cookie-cutter templates. Every plan is shaped around your goals.'],
    ],

    'values' => [
        ['icon' => 'lightbulb',    'title' => 'Innovation'],
        ['icon' => 'shield-check', 'title' => 'Transparency'],
        ['icon' => 'award',        'title' => 'Client success'],
        ['icon' => 'palette',      'title' => 'Creativity'],
        ['icon' => 'check',        'title' => 'Accountability'],
        ['icon' => 'trending-up',  'title' => 'Continuous improvement'],
    ],

    'founder' => [
        'name'  => 'Samin Sajid',
        'role'  => 'Founder',
        'bio'   => 'Founder and business leader, focused on helping businesses embrace digital transformation through marketing, technology, and innovation.',
        'bio_long' => 'With 10+ years of hands-on experience, Samin has led 1,200+ projects from first idea to measurable results. He built Progix Digital around a simple belief: businesses grow faster when strategy, creativity and technology work together.',
    ],

    'mission' => 'To empower businesses with innovative digital solutions that simplify growth, strengthen their online presence, and create meaningful customer experiences.',
    'vision'  => 'To become a trusted digital transformation partner for businesses by combining creativity, technology, and strategic thinking.',

    'faqs' => [
        ['What does Progix Digital do?', 'Progix Digital is a full-service digital agency that manages social media and paid ads, writes SEO content, builds websites and web apps, and creates AI chatbots and workflow automation. With 10+ years of experience and 1,200+ projects, we serve clients worldwide from one team, so strategy, creative and technology work together.'],
        ['How much does social media management cost?', 'Our social media management plans start at $199 per month for the Starter plan, which covers 20 posts and 3 platforms. The Growth plan is $299 per month and Premium is $499 per month. Each plan includes content planning, scheduling, reporting and revision rounds, with no long-term contract required.'],
        ['How much does a website cost?', 'A landing page starts at $129, a Business Website is $349 and an Advanced Website is $999. Larger custom platforms and web apps receive a tailored quote. Every price is listed openly on our pricing page, and we confirm the full scope in writing before any work starts.'],
        ['How long does a website take to build?', 'A landing page is usually delivered in 3–4 business days, a Business Website in 1–2 weeks and an Advanced Website in 2–4 weeks. Timelines depend on how quickly we receive your content and feedback. We confirm the exact delivery date in your quotation before starting.'],
        ['How much do paid ads management services cost?', 'Meta Ads management is $199 per month and Google Ads management is $299 per month. These fees cover campaign set-up, tracking, optimisation and reporting. The ad budget paid to Meta or Google is separate, and we recommend a starting spend based on your goals and market.'],
        ['How much does an AI chatbot or automation cost?', 'An AI Starter Agent for a website FAQ assistant starts at $99 as a one-time set-up. The AI Business Agent, trained on your knowledge base, is $299, and a full AI Automation System with end-to-end workflows starts at $499 per project. Complex integrations receive a custom quote.'],
        ['How much does SEO website content cost?', 'Website content starts at $99 one-time for up to 5 pages with the Starter package, and $199 for up to 10 pages with the Professional package. Content is written around keyword research so each page can rank, and it is delivered ready to publish on your website.'],
        ['How quickly can we get started?', 'You can start within a few days. Book a free consultation or send your project details, and we will reply with a clear scope and fixed price within 24 hours. Once you approve the quote and the first payment is arranged, our team begins planning straight away.'],
        ['Do I have to sign a long-term contract?', 'No. Our monthly services such as social media, ads management and website care are flexible and can be changed or paused with notice. One-time projects like websites and AI set-ups are priced per project, with the scope and deliverables written clearly into your quotation.'],
        ['Can I buy only one service?', 'Yes. Our packages work well together, but every service can be bought on its own. That includes a single month of social media posts, a one-time ads set-up, one landing page or one AI chatbot. You can add more services whenever your business is ready.'],
        ['Which industries do you work with?', 'We have worked across more than 37 industries and niches, including e-commerce, real estate, education, logistics, SaaS, recruitment and luxury retail. Clients range from global brands to fast-growing start-ups, and our process adapts to your market, audience and goals. If your niche is not listed, ask us how we would approach it.'],
        ['Do you work with clients outside Pakistan?', 'Yes. We serve clients worldwide and communicate by email, WhatsApp and video calls. Our team works Monday to Saturday, 10:00 to 19:00 Pakistan time, and we agree on call times that suit your time zone. We have delivered projects for clients across several countries.'],
        ['How do you report results?', 'Every plan includes clear reporting in plain English. Monthly summaries are standard, and higher tiers add weekly snapshots. Each report shows what we did, what it achieved and our recommended next steps, so you always know how your marketing or project is performing.'],
        ['What technologies do you use for web development?', 'We build with Laravel, React, Next.js, WordPress, Shopify and other modern tools, chosen to match your goals and budget. Every website is responsive, fast and SEO-ready. We also offer monthly care plans from $49 covering backups, updates and security after launch.'],
        ['How can I pay?', 'After your consultation we send an invoice with the agreed scope and price. Secure online payment links through Stripe and PayPal are being added to make this faster. Monthly services are billed in advance, and one-time projects are usually split into agreed stages.'],
    ],
];

