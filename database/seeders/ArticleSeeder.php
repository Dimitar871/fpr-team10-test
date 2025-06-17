<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Label;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Unlocking Daily Energy Through Mindful Nutrition',
                'excerpt' => 'Discover how small dietary changes can lead to sustained energy throughout your day.',
                'content' => 'Eating mindfully doesn’t mean restricting yourself—it means understanding what fuels your body. Whole foods like leafy greens, whole grains, and nuts provide long-lasting energy. Avoiding sugar crashes by balancing your meals can dramatically increase your daily vitality. Focus on incorporating a mix of macronutrients—complex carbs, healthy fats, and lean proteins—into every meal. Also, eat slowly, chew thoroughly, and listen to your body’s hunger and fullness cues to avoid overeating. This holistic approach keeps your energy consistent and your metabolism efficient.',
                'author' => 'Emily Carter',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'The Power of Morning Routines for Vitality',
                'excerpt' => 'A strong morning routine can set the tone for your entire day—here’s how.',
                'content' => 'Whether it’s a quick workout, 10 minutes of meditation, or a protein-packed breakfast, establishing a consistent morning routine improves mood, energy, and focus. Try stacking healthy habits like stretching, journaling, and hydration for a compounding effect on your vitality. Avoid checking your phone first thing in the morning—it can trigger stress and decision fatigue early in the day. Instead, engage in grounding activities that help you center yourself and establish control over your mindset and energy for the hours ahead.',
                'author' => 'David Kim',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Hydration Hacks for Natural Energy',
                'excerpt' => 'Feeling drained? You might just be dehydrated.',
                'content' => 'Staying hydrated is crucial for energy and brain function. Even mild dehydration can lead to fatigue, irritability, and poor concentration. Start your day with a glass of water, add electrolytes if you’re active, and keep a bottle with you to sip throughout the day. Herbal teas, fruits like watermelon, and foods with high water content also contribute to hydration. Consider tracking your intake with an app or setting reminders. Optimal hydration supports digestion, circulation, and the regulation of body temperature—all vital to sustained energy.',
                'author' => 'Nina Thompson',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Why Quality Sleep Is Your Secret Vitality Weapon',
                'excerpt' => 'You can’t pour from an empty cup—start with sleep.',
                'content' => 'Sleep impacts every aspect of your health, especially energy. Poor sleep habits disrupt hormone production, immune function, and cognitive performance. Maintain a consistent bedtime, avoid screens an hour before bed, and create a dark, cool sleeping environment. Also consider limiting caffeine after 2 PM and establishing a pre-sleep ritual—like reading or taking a warm bath—to signal to your body that it’s time to rest. Prioritizing sleep isn’t lazy; it’s a productivity tool that enhances every part of your day.',
                'author' => 'Lucas Reid',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Movement Over Motivation: Staying Active Daily',
                'excerpt' => 'You don’t need motivation—you need a system.',
                'content' => 'Incorporate movement into your day through small, repeatable actions. Walk after meals, stretch during breaks, or try 5-minute bursts of activity. Rather than chasing motivation, create a system that makes movement non-negotiable. Set calendar reminders or use a habit tracker to stay accountable. Regular activity boosts circulation, improves mood via endorphins, and increases stamina. Even short bouts of movement—like taking stairs or desk exercises—can significantly improve your vitality over time.',
                'author' => 'Sophia Allen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Vitality-Boosting Superfoods You Need Today',
                'excerpt' => 'Fuel your body with the right nutrients for maximum energy.',
                'content' => 'Superfoods are nutrient-dense and support your energy, immunity, and overall health. Blueberries, spinach, avocados, sweet potatoes, and wild salmon are among the most effective. Rich in antioxidants, omega-3s, and fiber, these foods help combat fatigue, regulate blood sugar, and reduce inflammation. Try adding chia seeds to smoothies, leafy greens to your meals, or berries as snacks. Variety is key—rotate your choices to avoid dietary monotony and ensure a broad nutrient intake that supports long-term vitality.',
                'author' => 'James Patel',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'The Role of Breathwork in Daily Vitality',
                'excerpt' => 'Breathe better, live better.',
                'content' => 'Breathing exercises such as box breathing, 4-7-8 breathing, or diaphragmatic breathing can reduce stress, increase oxygenation, and improve mental clarity. Many people don’t realize they’re shallow breathers. Practicing deep, controlled breathing helps activate the parasympathetic nervous system, reducing cortisol levels and enhancing relaxation. Over time, this practice supports better sleep, improved focus, and more stable energy throughout the day. Start with 5 minutes in the morning or before stressful situations to build the habit.',
                'author' => 'Olivia Brooks',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Digital Detox: Reclaiming Energy in a Screen-Heavy World',
                'excerpt' => 'Too much screen time can drain you—here’s how to take back control.',
                'content' => 'Excessive screen time impacts sleep, posture, and mental clarity. Blue light exposure can suppress melatonin production, leading to disrupted sleep cycles. Constant notifications and multitasking exhaust your mental resources. Start by turning off non-essential notifications, setting screen-free hours, and engaging in offline activities. Reading physical books, spending time in nature, or practicing hobbies can reinvigorate your energy and attention span. A digital detox doesn’t have to be extreme—small breaks make a big difference.',
                'author' => 'Aiden Wells',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Adaptogens and Herbal Support for Vital Living',
                'excerpt' => 'Ancient herbs for modern vitality.',
                'content' => 'Adaptogens like ashwagandha, rhodiola rosea, holy basil, and ginseng help the body adapt to stress, regulate hormones, and enhance resilience. These herbs have been used for centuries in Ayurvedic and Traditional Chinese Medicine. When taken consistently and in the right dosages, they can reduce fatigue, improve focus, and stabilize mood. Always consult with a healthcare professional, especially if you are pregnant, nursing, or taking medications. Natural doesn’t mean risk-free, but when used mindfully, adaptogens can be powerful allies for energy.',
                'author' => 'Chloe Nguyen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Mental Vitality: Guarding Your Energy from Negativity',
                'excerpt' => 'Protect your mind to protect your energy.',
                'content' => 'Mental vitality is as important as physical health. Exposure to toxic people, constant negativity, or overwhelming news can sap your energy. Set boundaries, limit media consumption, and practice gratitude or journaling to keep your mental state resilient. Build a positive environment by surrounding yourself with people who uplift you and engaging in activities that bring joy. Cultivate mindfulness through meditation or even daily walks to stay grounded and recharged in a noisy world.',
                'author' => 'Marcus Lee',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($articles as $article) {
            DB::table('articles')->insert($article);
        }
        // Now attach random labels to each article
        $labels = Label::all();

        Article::all()->each(function ($article) use ($labels) {
            // Pick 2 random labels per article (change number if needed)
            $randomLabels = $labels->random(2)->pluck('id')->toArray();

            // Attach labels to article
            $article->labels()->attach($randomLabels);
        });
    }
}
