export default {
    async fetch(request, env) {
        const url = new URL(request.url);

        // Validate API Key
        const API_KEY = "5d56dd65dd6556dusytfuyviu65d7i6gytc75fvcu6d"; // Replace with your actual key
        const queryKey = url.searchParams.get("key");

        if (!queryKey || queryKey !== API_KEY) {
            return new Response(JSON.stringify({ error: "Invalid API key." }), {
                status: 403,
                headers: { "Content-Type": "application/json" },
            });
        }

        try {
            // Query the database
            const results = await env.DB.prepare("SELECT UserID, Username, Agent, Reason FROM raider_bans")
                .all();

            // Send results as JSON
            return new Response(JSON.stringify(results.results), {
                status: 200,
                headers: { "Content-Type": "application/json" },
            });
        } catch (error) {
            return new Response(
                JSON.stringify({ error: "Failed to query the database.", details: error.message }),
                {
                    status: 500,
                    headers: { "Content-Type": "application/json" },
                }
            );
        }
    },
};
