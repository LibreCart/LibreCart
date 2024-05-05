class ApiPlatform {
    async get(endpoint: string) {
        const baseUrl = '/api/';

        try {
            const response = await fetch(baseUrl + endpoint);

            if (!response.ok) {
                throw new ErrorEvent('Network response was not ok');
            }

            const data = await response.json();

           // console.log(data['hydra:member']);

            return data['hydra:member'] ?? data;
        } catch (error) {
            console.error("Error fetching "+ endpoint +":", error);
        }

        /*
            .then((response) => {
                response.json();
            }).catch((error) => {
                console.error("Error fetching "+ endpoint +":", error);
            });
        
        return response;*/
    }
}


const instance = new ApiPlatform();

export default instance;